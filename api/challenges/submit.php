<?php
/**
 * Student challenge submission (multipart form: challenge_id + file).
 * Identity from session only. One active submission; resubmit only after reject.
 */
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/challenge_helpers.php';
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../middleware/csrf.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    error_response('Method Not Allowed', 405);
}

$user = require_auth();
if ($user['role'] !== 'student') {
    error_response('Only students can submit challenges', 403);
}
verify_csrf_token();

$challengeId = trim($_POST['challenge_id'] ?? '');
if ($challengeId === '' || empty($_FILES['file'])) {
    error_response('challenge_id and file are required', 400);
}

try {
    $db = get_db_connection();

    $st = $db->prepare("SELECT id, class_id, role FROM profiles WHERE id = ?");
    $st->execute([$user['id']]);
    $student = $st->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        error_response('Profile not found', 404);
    }

    $stmt = $db->prepare("SELECT * FROM challenges WHERE id = ? LIMIT 1");
    $stmt->execute([$challengeId]);
    $ch = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$ch || !student_can_see_challenge($db, $ch, $student)) {
        error_response('Challenge not available', 403);
    }

    if (challenge_deadline_passed($ch)) {
        error_response('The deadline for this challenge has passed. New submissions are closed.', 400);
    }

    // Active submission check
    $act = $db->prepare("
        SELECT id, status, attempt_number FROM challenge_submissions
        WHERE challenge_id = ? AND student_id = ? AND is_active = 1
        ORDER BY attempt_number DESC LIMIT 1
    ");
    $act->execute([$challengeId, $user['id']]);
    $active = $act->fetch(PDO::FETCH_ASSOC);

    if ($active && $active['status'] === 'pending') {
        error_response('You already have a submission pending review.', 400);
    }
    if ($active && $active['status'] === 'approved') {
        error_response('This challenge is already approved. Resubmission is not allowed.', 400);
    }

    $maxZip = (int)($ch['max_zip_mb'] ?: 10);
    $maxImg = (int)($ch['max_image_mb'] ?: 5);
    $stored = challenge_store_upload($_FILES['file'], $maxZip, $maxImg);
    if (!$stored['ok']) {
        error_response($stored['error'], 400);
    }

    // Allowed types from challenge
    $allowed = array_map('trim', explode(',', strtolower($ch['allowed_types'] ?? 'zip,image')));
    if (!in_array($stored['type'], $allowed, true)) {
        @unlink($stored['path']);
        error_response('This challenge does not accept ' . $stored['type'] . ' uploads.', 400);
    }

    $db->beginTransaction();

    $attempt = 1;
    if ($active) {
        // Deactivate previous (keep history)
        $db->prepare("UPDATE challenge_submissions SET is_active = 0 WHERE id = ?")->execute([$active['id']]);
        $attempt = ((int)$active['attempt_number']) + 1;
    }

    $sid = generate_uuid_v4();
    $ins = $db->prepare("
        INSERT INTO challenge_submissions (
            id, challenge_id, student_id, attempt_number, is_active, status,
            file_stored_name, file_original_name, file_mime, file_type, file_size
        ) VALUES (?, ?, ?, ?, 1, 'pending', ?, ?, ?, ?, ?)
    ");
    $ins->execute([
        $sid,
        $challengeId,
        $user['id'],
        $attempt,
        $stored['stored_name'],
        $stored['original_name'],
        $stored['mime'],
        $stored['type'],
        $stored['size'],
    ]);

    $db->commit();

    success_response([
        'submission_id' => $sid,
        'status' => 'pending',
        'attempt_number' => $attempt,
        'message' => 'Your project has been submitted successfully. A teacher or admin will review it.',
    ], 201);

} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log('Challenge submit error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
