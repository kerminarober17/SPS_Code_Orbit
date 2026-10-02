<?php
/**
 * Approve or reject a challenge submission.
 * Reviewer identity from session. Teachers only for authorized students.
 */
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/challenge_helpers.php';
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../middleware/csrf.php';

require_post_method();
$user = require_auth();
if (!in_array($user['role'], ['admin', 'teacher'], true)) {
    error_response('Forbidden', 403);
}
verify_csrf_token();

$data = get_json_request();
$submissionId = trim($data['submission_id'] ?? '');
$action = strtolower(trim($data['action'] ?? ''));
$feedback = trim($data['feedback'] ?? '');
$score = array_key_exists('score', $data) && $data['score'] !== null && $data['score'] !== ''
    ? max(0, min(100, (int)$data['score']))
    : null;

if ($submissionId === '' || !in_array($action, ['approve', 'reject'], true)) {
    error_response('submission_id and action (approve|reject) are required', 400);
}
if ($action === 'reject' && $feedback === '') {
    error_response('Feedback is required when rejecting a submission', 400);
}
if (mb_strlen($feedback) > 2000) {
    error_response('Feedback must be 2000 characters or fewer', 400);
}

try {
    $db = get_db_connection();

    $stmt = $db->prepare("
        SELECT cs.*, ch.xp_reward, ch.title AS challenge_title
        FROM challenge_submissions cs
        JOIN challenges ch ON cs.challenge_id = ch.id
        WHERE cs.id = ? AND cs.is_active = 1
        LIMIT 1
    ");
    $stmt->execute([$submissionId]);
    $sub = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$sub) {
        error_response('Submission not found', 404);
    }

    if ($user['role'] === 'teacher') {
        if (!teacher_can_review_student($db, $user['id'], $sub['student_id'])) {
            error_response('Forbidden: You are not authorized to review this student submission.', 403);
        }
    }

    $newStatus = $action === 'approve' ? 'approved' : 'rejected';

    $db->beginTransaction();

    $upd = $db->prepare("
        UPDATE challenge_submissions
        SET status = ?, feedback = ?, score = ?, reviewed_by = ?, reviewed_at = NOW(), updated_at = NOW()
        WHERE id = ?
    ");
    // Secrets-based admin has id=0 — do not write invalid FK into profiles
    $reviewerId = ($user['role'] === 'admin' && (empty($user['id']) || (int)$user['id'] === 0))
        ? null
        : $user['id'];
    $upd->execute([$newStatus, $feedback !== '' ? $feedback : null, $score, $reviewerId, $submissionId]);

    // Optional one-time XP on first approval (if xp_reward > 0 and xp_events table exists)
    if ($newStatus === 'approved' && (int)$sub['xp_reward'] > 0) {
        try {
            $chk = $db->prepare("
                SELECT id FROM xp_events
                WHERE user_id = ? AND source_type = 'challenge' AND source_id = ?
                LIMIT 1
            ");
            $chk->execute([$sub['student_id'], $sub['challenge_id']]);
            if (!$chk->fetch()) {
                $xpId = generate_uuid_v4();
                $xpAmt = (int)$sub['xp_reward'];
                $db->prepare("
                    INSERT INTO xp_events (id, user_id, amount, source_type, source_id, description, created_at)
                    VALUES (?, ?, ?, 'challenge', ?, ?, NOW())
                ")->execute([
                    $xpId,
                    $sub['student_id'],
                    $xpAmt,
                    $sub['challenge_id'],
                    'Challenge approved: ' . ($sub['challenge_title'] ?? ''),
                ]);
                // Best-effort gamification update
                $db->prepare("
                    INSERT INTO student_gamification (user_id, total_xp, level, updated_at)
                    VALUES (?, ?, 1, NOW())
                    ON DUPLICATE KEY UPDATE total_xp = total_xp + VALUES(total_xp), updated_at = NOW()
                ")->execute([$sub['student_id'], $xpAmt]);
            }
        } catch (Exception $xpEx) {
            // Do not fail review if XP schema differs
            error_log('Challenge XP award skipped: ' . $xpEx->getMessage());
        }
    }

    $db->commit();

    success_response([
        'submission_id' => $submissionId,
        'status' => $newStatus,
        'message' => $newStatus === 'approved' ? 'Submission approved' : 'Submission rejected',
    ]);

} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log('Challenge review error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
