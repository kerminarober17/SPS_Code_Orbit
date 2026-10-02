<?php
/**
 * List challenges for the current user role.
 * Student: published, visible to them, with latest active submission status.
 * Admin: all (optional filters).
 * Teacher: published challenges that have submissions from their students.
 */
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/challenge_helpers.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
$user = require_auth();

try {
    $db = get_db_connection();
    $filter = $_GET['filter'] ?? 'all';
    $statusFilter = $_GET['status'] ?? null;

    if ($user['role'] === 'student') {
        // Ensure we have class_id
        $stmt = $db->prepare("SELECT id, class_id, full_name, role FROM profiles WHERE id = ? LIMIT 1");
        $stmt->execute([$user['id']]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$student) {
            error_response('Student profile not found', 404);
        }

        $stmt = $db->query("
            SELECT ch.*,
                   c.title AS course_title,
                   cl.name AS class_name
            FROM challenges ch
            LEFT JOIN courses c ON ch.course_id = c.id
            LEFT JOIN classes cl ON ch.class_id = cl.id
            WHERE ch.is_published = 1 AND ch.is_archived = 0
            ORDER BY ch.created_at DESC
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $out = [];
        $seen_challenge_ids = [];

        foreach ($rows as $ch) {
            $cid = (string)($ch['id'] ?? '');
            if ($cid !== '' && isset($seen_challenge_ids[$cid])) {
                continue;
            }
            if (!student_can_see_challenge($db, $ch, $student)) {
                continue;
            }
            if ($cid !== '') {
                $seen_challenge_ids[$cid] = true;
            }
            $sub = $db->prepare("
                SELECT id, status, feedback, score, submitted_at, reviewed_at, attempt_number,
                       file_original_name, file_type, file_size
                FROM challenge_submissions
                WHERE challenge_id = ? AND student_id = ? AND is_active = 1
                ORDER BY attempt_number DESC LIMIT 1
            ");
            $sub->execute([$ch['id'], $user['id']]);
            $submission = $sub->fetch(PDO::FETCH_ASSOC) ?: null;

            $statusLabel = 'not_submitted';
            if ($submission) {
                if ($submission['status'] === 'pending') $statusLabel = 'pending';
                elseif ($submission['status'] === 'approved') $statusLabel = 'approved';
                elseif ($submission['status'] === 'rejected') $statusLabel = 'rejected';
            }

            if ($filter === 'available' && $submission) continue;
            if ($filter === 'submitted' && !$submission) continue;
            if ($filter === 'pending' && $statusLabel !== 'pending') continue;
            if ($filter === 'approved' && $statusLabel !== 'approved') continue;
            if ($filter === 'rejected' && $statusLabel !== 'rejected') continue;
            if ($filter === 'needs_resubmission' && $statusLabel !== 'rejected') continue;

            $out[] = [
                'id' => $ch['id'],
                'title' => $ch['title'],
                'description' => $ch['description'],
                'difficulty' => $ch['difficulty'],
                'course_id' => $ch['course_id'],
                'course_title' => $ch['course_title'],
                'deadline' => $ch['deadline'],
                'deadline_passed' => challenge_deadline_passed($ch),
                'xp_reward' => (int)$ch['xp_reward'],
                'allowed_types' => $ch['allowed_types'],
                'max_zip_mb' => (int)$ch['max_zip_mb'],
                'max_image_mb' => (int)$ch['max_image_mb'],
                'submission_status' => $statusLabel,
                'submission' => $submission,
            ];
        }

        success_response(['challenges' => $out]);
    }

    if ($user['role'] === 'admin') {
        $sql = "
            SELECT ch.*,
                   c.title AS course_title,
                   cl.name AS class_name,
                   (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.challenge_id = ch.id AND cs.is_active = 1) AS submission_count,
                   (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.challenge_id = ch.id AND cs.is_active = 1 AND cs.status = 'pending') AS pending_count,
                   (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.challenge_id = ch.id AND cs.is_active = 1 AND cs.status = 'approved') AS approved_count,
                   (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.challenge_id = ch.id AND cs.is_active = 1 AND cs.status = 'rejected') AS rejected_count
            FROM challenges ch
            LEFT JOIN courses c ON ch.course_id = c.id
            LEFT JOIN classes cl ON ch.class_id = cl.id
            WHERE 1=1
        ";
        $params = [];
        if ($filter === 'published') {
            $sql .= " AND ch.is_published = 1 AND ch.is_archived = 0";
        } elseif ($filter === 'draft') {
            $sql .= " AND ch.is_published = 0 AND ch.is_archived = 0";
        } elseif ($filter === 'archived') {
            $sql .= " AND ch.is_archived = 1";
        } else {
            $sql .= " AND ch.is_archived = 0";
        }
        $sql .= " ORDER BY ch.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        success_response(['challenges' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }

    // Teacher: challenges with relevant submissions
    $stmt = $db->prepare("
        SELECT DISTINCT ch.id, ch.title, ch.description, ch.difficulty, ch.deadline, ch.is_published,
               ch.course_id, c.title AS course_title,
               (SELECT COUNT(*) FROM challenge_submissions cs
                JOIN profiles stu ON cs.student_id = stu.id
                LEFT JOIN classes cl ON stu.class_id = cl.id
                LEFT JOIN grades g ON cl.grade_id = g.id
                WHERE cs.challenge_id = ch.id AND cs.is_active = 1 AND (
                    g.academic_group_id IN (SELECT academic_group_id FROM teacher_academic_groups WHERE teacher_id = ?)
                    OR cl.id IN (SELECT class_id FROM teacher_classes WHERE teacher_id = ?)
                    OR stu.id IN (SELECT student_id FROM teacher_student_assignments WHERE teacher_id = ?)
                )) AS submission_count,
               (SELECT COUNT(*) FROM challenge_submissions cs
                JOIN profiles stu ON cs.student_id = stu.id
                LEFT JOIN classes cl ON stu.class_id = cl.id
                LEFT JOIN grades g ON cl.grade_id = g.id
                WHERE cs.challenge_id = ch.id AND cs.is_active = 1 AND cs.status = 'pending' AND (
                    g.academic_group_id IN (SELECT academic_group_id FROM teacher_academic_groups WHERE teacher_id = ?)
                    OR cl.id IN (SELECT class_id FROM teacher_classes WHERE teacher_id = ?)
                    OR stu.id IN (SELECT student_id FROM teacher_student_assignments WHERE teacher_id = ?)
                )) AS pending_count
        FROM challenges ch
        LEFT JOIN courses c ON ch.course_id = c.id
        WHERE ch.is_published = 1 AND ch.is_archived = 0
        ORDER BY ch.created_at DESC
    ");
    $tid = $user['id'];
    $stmt->execute([$tid, $tid, $tid, $tid, $tid, $tid]);
    success_response(['challenges' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);

} catch (Exception $e) {
    error_log('Challenges list error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
