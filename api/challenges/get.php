<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/challenge_helpers.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
$user = require_auth();

$id = trim($_GET['id'] ?? '');
if ($id === '') {
    error_response('Challenge id is required', 400);
}

try {
    $db = get_db_connection();
    $stmt = $db->prepare("
        SELECT ch.*, c.title AS course_title, cl.name AS class_name
        FROM challenges ch
        LEFT JOIN courses c ON ch.course_id = c.id
        LEFT JOIN classes cl ON ch.class_id = cl.id
        WHERE ch.id = ?
        LIMIT 1
    ");
    $stmt->execute([$id]);
    $ch = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$ch) {
        error_response('Challenge not found', 404);
    }

    if ($user['role'] === 'student') {
        $st = $db->prepare("SELECT id, class_id, role FROM profiles WHERE id = ?");
        $st->execute([$user['id']]);
        $student = $st->fetch(PDO::FETCH_ASSOC);
        if (!$student || !student_can_see_challenge($db, $ch, $student)) {
            error_response('Challenge not available', 403);
        }

        $sub = $db->prepare("
            SELECT id, status, feedback, score, submitted_at, reviewed_at, attempt_number,
                   file_original_name, file_type, file_size, reviewed_by
            FROM challenge_submissions
            WHERE challenge_id = ? AND student_id = ? AND is_active = 1
            ORDER BY attempt_number DESC LIMIT 1
        ");
        $sub->execute([$id, $user['id']]);
        $active = $sub->fetch(PDO::FETCH_ASSOC) ?: null;

        $hist = $db->prepare("
            SELECT id, status, feedback, score, submitted_at, reviewed_at, attempt_number,
                   file_original_name, file_type
            FROM challenge_submissions
            WHERE challenge_id = ? AND student_id = ?
            ORDER BY attempt_number DESC
        ");
        $hist->execute([$id, $user['id']]);
        $history = $hist->fetchAll(PDO::FETCH_ASSOC);

        $statusLabel = 'not_submitted';
        if ($active) {
            $statusLabel = $active['status'];
        }

        success_response([
            'challenge' => [
                'id' => $ch['id'],
                'title' => $ch['title'],
                'description' => $ch['description'],
                'instructions' => $ch['instructions'],
                'difficulty' => $ch['difficulty'],
                'course_title' => $ch['course_title'],
                'deadline' => $ch['deadline'],
                'deadline_passed' => challenge_deadline_passed($ch),
                'xp_reward' => (int)$ch['xp_reward'],
                'allowed_types' => $ch['allowed_types'],
                'max_zip_mb' => (int)$ch['max_zip_mb'],
                'max_image_mb' => (int)$ch['max_image_mb'],
            ],
            'submission_status' => $statusLabel,
            'submission' => $active,
            'history' => $history,
            'can_submit' => (
                (!$active || $active['status'] === 'rejected')
                && !challenge_deadline_passed($ch)
            ),
        ]);
    }

    // Admin / teacher
    if ($user['role'] !== 'admin' && $user['role'] !== 'teacher') {
        error_response('Forbidden', 403);
    }

    success_response(['challenge' => $ch]);

} catch (Exception $e) {
    error_log('Challenge get error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
