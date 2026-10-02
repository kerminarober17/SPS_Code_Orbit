<?php
/**
 * Protected download of a challenge submission file.
 * Students: own files only.
 * Teachers: authorized students only.
 * Admins: all.
 */
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/challenge_helpers.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
$user = require_auth();

$submissionId = trim($_GET['submission_id'] ?? '');
if ($submissionId === '') {
    error_response('submission_id is required', 400);
}

try {
    $db = get_db_connection();
    $stmt = $db->prepare("SELECT * FROM challenge_submissions WHERE id = ? LIMIT 1");
    $stmt->execute([$submissionId]);
    $sub = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$sub) {
        error_response('Submission not found', 404);
    }

    $allowed = false;
    if ($user['role'] === 'admin') {
        $allowed = true;
    } elseif ($user['role'] === 'student' && $sub['student_id'] === $user['id']) {
        $allowed = true;
    } elseif ($user['role'] === 'teacher') {
        $allowed = teacher_can_review_student($db, $user['id'], $sub['student_id']);
    }

    if (!$allowed) {
        error_response('Forbidden', 403);
    }

    $root = challenge_upload_root();
    $path = realpath(rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $sub['file_stored_name']);
    if ($path === false || strpos($path, realpath($root)) !== 0 || !is_file($path)) {
        error_response('File not found', 404);
    }

    $downloadName = $sub['file_original_name'] ?: basename($path);
    $mime = $sub['file_mime'] ?: 'application/octet-stream';

    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($path));
    header('Content-Disposition: attachment; filename="' . str_replace('"', '', $downloadName) . '"');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, no-store');
    readfile($path);
    exit;

} catch (Exception $e) {
    error_log('Challenge download error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
