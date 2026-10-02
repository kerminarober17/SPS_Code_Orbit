<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
$user = require_auth();
// Accept secrets-based admin (role=admin via is_admin_session) OR teacher
if (!in_array($user['role'] ?? '', ['admin', 'teacher'], true)) {
    error_response('Forbidden', 403);
}

try {
    $db = get_db_connection();

    // If challenges system not migrated yet, return empty list (not 500)
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $tableSet = array_map('strtolower', array_map('strval', $tables));
    if (!in_array('challenge_submissions', $tableSet, true) || !in_array('challenges', $tableSet, true)) {
        success_response(['submissions' => [], 'notice' => 'Challenge tables not installed yet.']);
    }

    $challengeId = trim($_GET['challenge_id'] ?? '');
    $status = trim($_GET['status'] ?? '');
    $q = trim($_GET['q'] ?? '');

    $sql = "
        SELECT
            cs.id AS submission_id,
            cs.challenge_id,
            cs.student_id,
            cs.attempt_number,
            cs.is_active,
            cs.status,
            cs.file_original_name,
            cs.file_type,
            cs.file_size,
            cs.feedback,
            cs.score,
            cs.submitted_at,
            cs.reviewed_at,
            cs.reviewed_by,
            stu.full_name AS student_name,
            stu.username AS student_username,
            cl.name AS class_name,
            g.name AS grade_name,
            ag.name AS academic_group_name,
            ch.title AS challenge_title,
            rev.full_name AS reviewer_name
        FROM challenge_submissions cs
        JOIN profiles stu ON cs.student_id = stu.id
        LEFT JOIN classes cl ON stu.class_id = cl.id
        LEFT JOIN grades g ON cl.grade_id = g.id
        LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id
        JOIN challenges ch ON cs.challenge_id = ch.id
        LEFT JOIN profiles rev ON cs.reviewed_by = rev.id
        WHERE cs.is_active = 1
    ";
    $params = [];

    if (($user['role'] ?? '') === 'teacher') {
        $sql .= " AND (
            g.academic_group_id IN (SELECT academic_group_id FROM teacher_academic_groups WHERE teacher_id = ?)
            OR cl.id IN (SELECT class_id FROM teacher_classes WHERE teacher_id = ?)
            OR stu.id IN (SELECT student_id FROM teacher_student_assignments WHERE teacher_id = ?)
        )";
        $params[] = $user['id'];
        $params[] = $user['id'];
        $params[] = $user['id'];
    }
    // Admin (secrets session): no extra filter — see all submissions

    if ($challengeId !== '') {
        $sql .= " AND cs.challenge_id = ?";
        $params[] = $challengeId;
    }
    if ($status !== '' && $status !== 'all') {
        $sql .= " AND cs.status = ?";
        $params[] = $status;
    }
    if ($q !== '') {
        $sql .= " AND (stu.full_name LIKE ? OR stu.username LIKE ? OR ch.title LIKE ?)";
        $like = '%' . $q . '%';
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }

    $sql .= " ORDER BY cs.submitted_at DESC LIMIT 200";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    success_response(['submissions' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);

} catch (Throwable $e) {
    error_log('Challenge submissions error: ' . $e->getMessage());
    // Prefer JSON error over raw 500 HTML
    error_response('Server error loading submissions: ' . (defined('APP_ENV') && APP_ENV === 'development' ? $e->getMessage() : 'Please try again.'), 500);
}
