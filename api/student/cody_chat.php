<?php
/**
 * Cody chat API — authenticated students only.
 * POST JSON: { message, mode?, history?, context?, csrf_token }
 * Never exposes OpenRouter key or raw provider errors.
 *
 * InfinityFree note: HTTP 403 responses are often replaced by the host's
 * error portal (errors.infinityfree.net), which breaks fetch/CORS.
 * This endpoint intentionally uses 400/401/422/429/503 instead of 403.
 */

// Prevent host-level HTML error pages from leaking into JSON clients
ini_set('display_errors', '0');
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/cody_service.php';
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../middleware/csrf.php';

// CORS-safe same-origin JSON headers early
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

// Preflight (harmless on same-origin; helps if a proxy injects Origin)
if ($method === 'OPTIONS') {
    header('Allow: POST, OPTIONS, GET');
    http_response_code(204);
    exit;
}

// Lightweight health probe — does not call OpenRouter
if ($method === 'GET') {
    $loggedIn = is_logged_in();
    success_response([
        'service' => 'cody',
        'enabled' => (bool) CODY_ENABLED,
        'configured' => (CODY_OPENROUTER_API_KEY !== '' && CODY_OPENROUTER_API_KEY !== null),
        'authenticated' => $loggedIn,
        'model_set' => CODY_PRIMARY_MODEL !== '',
    ]);
}

if ($method !== 'POST') {
    // Use 405, not 403
    error_response('Method Not Allowed. Use POST.', 405);
}

// --- CSRF (avoid 403 status for InfinityFree compatibility) ---
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? '';
if ($token === '') {
    $inputPeek = json_decode(file_get_contents('php://input'), true);
    if (is_array($inputPeek) && !empty($inputPeek['csrf_token'])) {
        $token = $inputPeek['csrf_token'];
    }
    // Restore body for get_json_request by storing peek
    $GLOBALS['_cody_json_body'] = is_array($inputPeek) ? $inputPeek : null;
} else {
    $GLOBALS['_cody_json_body'] = null;
}

$sessionToken = get_csrf_token();
if ($token === '' || !hash_equals($sessionToken, (string)$token)) {
    error_response('Invalid or missing CSRF token. Please refresh the page and try again.', 400);
}

// --- Auth (avoid 403) ---
if (!is_logged_in()) {
    error_response('Please log in to use Cody.', 401);
}
$user = current_user();
$allowedRoles = ['student', 'teacher', 'admin'];
if (!$user || !in_array($user['role'] ?? '', $allowedRoles, true)) {
    error_response('You do not have permission to use Cody.', 401);
}

if (!CODY_ENABLED) {
    error_response(cody_friendly_error('disabled', $user['preferred_language'] ?? 'en'), 503);
}

if (!cody_check_rate_limit(CODY_RATE_LIMIT_PER_MINUTE)) {
    $lang = $user['preferred_language'] ?? 'en';
    error_response(cody_friendly_error('rate_limited', $lang), 429);
}

$data = $GLOBALS['_cody_json_body'];
if (!is_array($data) || empty($data)) {
    $data = get_json_request();
}
if (empty($data) && !empty($_POST)) {
    $data = $_POST;
}

$message = isset($data['message']) ? trim((string)$data['message']) : '';
if ($message === '') {
    error_response('Message is required', 400);
}
if (mb_strlen($message) > 4000) {
    error_response('Your message is too long. Please shorten it and try again.', 400);
}

$mode = isset($data['mode']) ? strtolower(trim((string)$data['mode'])) : 'chat';
$allowedModes = ['chat', 'lesson', 'hint', 'debug', 'exam', 'concept'];
if (!in_array($mode, $allowedModes, true)) {
    $mode = 'chat';
}

$lang = $user['preferred_language'] ?? 'en';
if (!empty($data['language']) && in_array($data['language'], ['en', 'ar'], true)) {
    $lang = $data['language'];
}

$context = [];
if (!empty($data['context']) && is_array($data['context'])) {
    $ctx = $data['context'];
    $keys = [
        'course_title', 'chapter_title', 'lesson_title', 'topic', 'objective',
        'language', 'explanation', 'student_code', 'compiler_output'
    ];
    foreach ($keys as $k) {
        if (!empty($ctx[$k]) && is_string($ctx[$k])) {
            $max = in_array($k, ['student_code'], true) ? 4000 : (in_array($k, ['explanation', 'compiler_output'], true) ? 2000 : 300);
            $context[$k] = mb_substr(trim($ctx[$k]), 0, $max);
        }
    }
    if (!empty($ctx['is_exam'])) {
        $context['is_exam'] = true;
        if ($mode !== 'exam') {
            $mode = 'exam';
        }
    }
}

$history = [];
if (!empty($data['history']) && is_array($data['history'])) {
    foreach ($data['history'] as $h) {
        if (!is_array($h)) continue;
        $role = $h['role'] ?? '';
        $content = isset($h['content']) ? trim((string)$h['content']) : '';
        if (!in_array($role, ['user', 'assistant'], true) || $content === '') continue;
        if (mb_strlen($content) > 4000) {
            $content = mb_substr($content, 0, 4000);
        }
        $history[] = ['role' => $role, 'content' => $content];
        if (count($history) >= 16) break;
    }
}
$history = cody_trim_history($history, 12);

$system = cody_system_prompt($lang, $mode, $context);

$messages = [
    ['role' => 'system', 'content' => $system],
];
foreach ($history as $h) {
    $messages[] = $h;
}
$messages[] = ['role' => 'user', 'content' => $message];

try {
    $result = cody_call_openrouter($messages);
} catch (Throwable $e) {
    error_log('Cody exception: ' . $e->getMessage());
    error_response(cody_friendly_error('server_error', $lang), 503);
}

if (!$result['ok']) {
    $friendly = cody_friendly_error($result['error'] ?? 'unknown', $lang);
    $code = 503;
    if (($result['error'] ?? '') === 'rate_limited') {
        $code = 429;
    } elseif (($result['error'] ?? '') === 'not_configured') {
        $code = 503;
    }
    error_response($friendly, $code);
}

success_response([
    'reply' => $result['content'],
    'mode' => $mode,
    'model' => null,
]);
