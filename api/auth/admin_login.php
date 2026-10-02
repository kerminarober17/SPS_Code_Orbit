<?php
/**
 * Admin login — credentials from server secrets ONLY (not the database).
 * Separate from student/teacher authentication.
 */
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../middleware/csrf.php';

require_post_method();

// First-time admin login does not require CSRF (no prior session token).
// Session is established only after successful verification.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simple per-session brute-force guard (no DB)
$failKey = 'admin_login_fails';
$failCount = (int)($_SESSION[$failKey] ?? 0);
$failSince = (int)($_SESSION['admin_login_fail_ts'] ?? 0);
if ($failCount >= 8 && (time() - $failSince) < 900) {
    error_response('Too many failed attempts. Try again later.', 429);
}
if ($failCount >= 8 && (time() - $failSince) >= 900) {
    $_SESSION[$failKey] = 0;
    $failCount = 0;
}

$data = get_json_request();
if (empty($data) && !empty($_POST)) {
    $data = $_POST;
}

$username = trim((string)($data['username'] ?? ''));
$password = (string)($data['password'] ?? '');

if ($username === '' || $password === '') {
    error_response('Username and password are required', 400);
}

$adminUser = (string) sps_config_value('ADMIN_USERNAME', '');
$adminHash = (string) sps_config_value('ADMIN_PASSWORD_HASH', '');

if ($adminUser === '' || $adminHash === '' || $adminHash === 'paste_password_hash_here') {
    error_log('Admin login refused: ADMIN_USERNAME / ADMIN_PASSWORD_HASH not configured');
    error_response('Admin login is not configured on this server.', 503);
}

$userOk = hash_equals($adminUser, $username);
$passOk = $userOk && password_verify($password, $adminHash);

if (!$passOk) {
    $_SESSION[$failKey] = $failCount + 1;
    $_SESSION['admin_login_fail_ts'] = time();
    // Generic message — do not reveal which field failed
    error_response('Invalid admin credentials', 401);
}

// Success: clear fail counters, establish admin-only session
unset($_SESSION[$failKey], $_SESSION['admin_login_fail_ts']);
session_regenerate_id(true);

// Admin session flags (secrets-based — not a DB user)
$_SESSION['is_admin'] = true;
$_SESSION['admin_authenticated'] = true;
$_SESSION['admin_username'] = $adminUser;

// Explicitly clear any student/teacher identity from this session
unset(
    $_SESSION['user_id'],
    $_SESSION['username'],
    $_SESSION['full_name'],
    $_SESSION['role'],
    $_SESSION['class_id'],
    $_SESSION['avatar_url'],
    $_SESSION['preferred_language']
);

success_response([
    'message' => 'Admin login successful',
    'user' => [
        'id' => 0,
        'username' => $adminUser,
        'full_name' => 'Administrator',
        'role' => 'admin',
        'class_id' => null,
        'avatar_url' => null,
        'preferred_language' => 'en',
    ],
    'csrf_token' => get_csrf_token(),
]);
