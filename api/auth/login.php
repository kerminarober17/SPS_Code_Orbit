<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_post_method();

// Ensure session is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Support both JSON payloads and form-encoded POST
$data = get_json_request();
if (empty($data) && !empty($_POST)) {
    $data = $_POST;
}

$username = trim($data['username'] ?? $_POST['username'] ?? '');
$password = $data['password'] ?? $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    error_response('Username and password are required', 400);
}

if (strlen($username) > 100 || strlen($password) > 128) {
    error_response('Invalid credentials length', 400);
}

try {
    $db = get_db_connection();

    // Prefer full column set (is_active + preferred_language). Fall back if migrations
    // 001/003 have not been applied yet so login does not hard-fail with unknown column.
    $user = null;
    try {
        $stmt = $db->prepare("
            SELECT id, username, password_hash, full_name, role, class_id, avatar_url, is_active, preferred_language
            FROM profiles
            WHERE LOWER(username) = LOWER(?)
            LIMIT 1
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $colEx) {
        // Unknown column (migrations not applied) — core columns only
        error_log('Login: full SELECT failed, retrying core columns: ' . $colEx->getMessage());
        $stmt = $db->prepare("
            SELECT id, username, password_hash, full_name, role, class_id, avatar_url
            FROM profiles
            WHERE LOWER(username) = LOWER(?)
            LIMIT 1
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
        error_response('Invalid username or password', 401);
    }

    // Enforce account activation when is_active column is present
    if (array_key_exists('is_active', $user) && $user['is_active'] !== null && (int)$user['is_active'] !== 1) {
        error_response('Account is deactivated. Please contact an administrator.', 403);
    }

    // Regenerate session ID to prevent session fixation attacks
    session_regenerate_id(true);

    // Student login must not keep a secrets-based admin session
    unset($_SESSION['is_admin'], $_SESSION['admin_authenticated'], $_SESSION['admin_username']);

    // Preferred language (migration 003); default en if column missing/null
    $pref_lang = 'en';
    if (!empty($user['preferred_language']) && in_array($user['preferred_language'], ['en', 'ar'], true)) {
        $pref_lang = $user['preferred_language'];
    }

    // Store basic user info in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['class_id'] = $user['class_id'] ?? null;
    $_SESSION['avatar_url'] = $user['avatar_url'] ?? null;
    $_SESSION['preferred_language'] = $pref_lang;
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    success_response([
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'class_id' => $user['class_id'] ?? null,
            'avatar_url' => $user['avatar_url'] ?? null,
            'preferred_language' => $pref_lang
        ],
        'csrf_token' => $_SESSION['csrf_token']
    ]);

} catch (PDOException $e) {
    // Never expose SQLSTATE, host, user, or DB name to the client
    error_log('Login PDO Error: ' . $e->getMessage());
    error_response('Authentication is temporarily unavailable. Please try again later.', 503);
} catch (Exception $e) {
    error_log('Login Server Error: ' . $e->getMessage());
    $msg = $e->getMessage();
    if (stripos($msg, 'Database connection') !== false || stripos($msg, 'Database configuration') !== false) {
        error_response('Authentication is temporarily unavailable. Please try again later.', 503);
    }
    error_response('Authentication failed. Please try again.', 500);
}
