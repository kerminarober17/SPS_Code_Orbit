<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/response.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.gc_maxlifetime', (string) SESSION_LIFETIME);
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');
    if ($https) {
        ini_set('session.cookie_secure', '1');
    }
    session_start();
}

function is_admin_session() {
    return !empty($_SESSION['is_admin']) || !empty($_SESSION['admin_authenticated']);
}

function is_logged_in() {
    return isset($_SESSION['user_id']) || is_admin_session();
}

function current_user() {
    if (is_admin_session()) {
        return [
            'id' => 0,
            'username' => $_SESSION['admin_username'] ?? 'admin',
            'full_name' => 'Administrator',
            'role' => 'admin',
            'class_id' => null,
            'avatar_url' => null,
            'preferred_language' => 'en',
        ];
    }
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'full_name' => $_SESSION['full_name'],
        'role' => $_SESSION['role'],
        'class_id' => $_SESSION['class_id'] ?? null,
        'avatar_url' => $_SESSION['avatar_url'] ?? null,
        'preferred_language' => $_SESSION['preferred_language'] ?? 'en'
    ];
}

function require_auth($roles = []) {
    if (!is_logged_in()) {
        error_response('Unauthorized', 401);
    }
    $user = current_user();
    if (!empty($roles) && !in_array($user['role'], $roles, true)) {
        error_response('Forbidden', 403);
    }
    return $user;
}
