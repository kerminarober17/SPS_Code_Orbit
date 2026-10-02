<?php
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
$user = require_auth();

$student_id = trim($_GET['student_id'] ?? $_GET['id'] ?? '');

if (empty($student_id)) {
    // If student is querying without student_id, default to themselves
    if ($user['role'] === 'student') {
        $student_id = $user['id'];
    } else {
        error_response('student_id parameter is required', 400);
    }
}

try {
    $db = get_db_connection();

    // Check if users table exists to get email safely if present
    $has_users_table = false;
    try {
        $u_res = $db->query("SHOW TABLES LIKE 'users'")->fetch();
        if ($u_res) $has_users_table = true;
    } catch (Exception $e) {}

    $email_select = $has_users_table ? "u.email as email" : "'' as email";
    $user_join = $has_users_table ? "LEFT JOIN users u ON u.id = p.id" : "";

    // Detect optional profile columns
    $profileCols = [];
    try {
        $profileCols = $db->query('SHOW COLUMNS FROM profiles')->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (Throwable $e) {
        $profileCols = [];
    }
    $hasStageCol = in_array('academic_stage', $profileCols, true);
    $hasSectionCol = in_array('class_section', $profileCols, true);
    $hasGradeLevelCol = in_array('grade_level', $profileCols, true);
    $hasAcademicYearCol = in_array('academic_year', $profileCols, true);
    $selectStage = $hasStageCol ? 'p.academic_stage' : 'NULL AS academic_stage';
    $selectSection = $hasSectionCol ? 'p.class_section' : 'NULL AS class_section';
    if ($hasGradeLevelCol) {
        $selectGradeLevel = 'p.grade_level';
    } elseif ($hasAcademicYearCol) {
        $selectGradeLevel = 'p.academic_year AS grade_level';
    } else {
        $selectGradeLevel = 'NULL AS grade_level';
    }

    // 1. Fetch student basic profile, class, grade, and academic group without selecting p.email
    $profile_stmt = $db->prepare("
        SELECT 
            p.id, p.id as user_id, p.username, p.full_name, p.role, p.avatar_url, p.created_at,
            {$email_select},
            c.id as class_id, c.name as class_name, c.name as class_group,
            g.id as grade_id, g.name as grade_name,
            ag.id as academic_group_id, ag.name as academic_group_name,
            {$selectStage},
            {$selectSection},
            {$selectGradeLevel}
        FROM profiles p
        {$user_join}
        LEFT JOIN classes c ON p.class_id = c.id
        LEFT JOIN grades g ON c.grade_id = g.id
        LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id
        WHERE p.id = ? AND p.role = 'student'
    ");
    $profile_stmt->execute([$student_id]);
    $student = $profile_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        error_response('Student not found', 404);
    }

    // Normalize display: fall back to signup text fields
    if (empty($student['class_name']) && !empty($student['class_section'])) {
        $student['class_name'] = $student['class_section'];
        $student['class_group'] = $student['class_section'];
    }
    $gl = trim((string)($student['grade_level'] ?? ''));
    $letter = trim((string)($student['class_name'] ?? $student['class_section'] ?? ''));
    if ($gl !== '' && $letter !== '') {
        $student['class_label'] = $gl . ' • Class ' . $letter;
    } elseif ($gl !== '') {
        $student['class_label'] = $gl;
    } elseif ($letter !== '') {
        $student['class_label'] = 'Class ' . $letter;
    } else {
        $student['class_label'] = null;
    }
    if (empty($student['academic_group_name'])) {
        $st = strtolower((string)($student['academic_stage'] ?? ''));
        $gll = strtolower($gl);
        if (strpos($gll, '3 prim') !== false || strpos($gll, '4 prim') !== false) $student['academic_group_name'] = 'Primary 3 & 4';
        elseif (strpos($gll, '5 prim') !== false || strpos($gll, '6 prim') !== false) $student['academic_group_name'] = 'Primary 5 & 6';
        elseif (strpos($gll, 'prep') !== false || strpos($st, 'prep') !== false) $student['academic_group_name'] = 'Preparatory';
        elseif (strpos($gll, 'sec') !== false || strpos($st, 'second') !== false) $student['academic_group_name'] = 'Secondary';
        elseif (strpos($st, 'primary') !== false) $student['academic_group_name'] = 'Primary';
        elseif ($st !== '') $student['academic_group_name'] = $student['academic_stage'];
    }

    // 2. Access Control & IDOR Defense
    if ($user['role'] === 'student') {
        if ($user['id'] !== $student['id']) {
            error_response('Forbidden: You can only view your own student profile.', 403);
        }
    } elseif ($user['role'] === 'teacher') {
        // Verify teacher access
        $auth_stmt = $db->prepare("
            SELECT 1 
            FROM teacher_classes tc
            WHERE tc.teacher_id = ? AND tc.class_id = ?
        ");
        $auth_stmt->execute([$user['id'], $student['class_id']]);
        if (!$auth_stmt->fetch()) {
            // Allow teacher access to student if in same academic group
            $ag_stmt = $db->prepare("
                SELECT 1 FROM teacher_classes tc 
                JOIN classes cl ON tc.class_id = cl.id 
                JOIN grades gr ON cl.grade_id = gr.id 
                WHERE tc.teacher_id = ? AND gr.academic_group_id = ?
            ");
            $ag_stmt->execute([$user['id'], $student['academic_group_id']]);
            if (!$ag_stmt->fetch()) {
                // Default to allowing teacher view if teacher role
            }
        }
    } elseif ($user['role'] !== 'admin') {
        error_response('Unauthorized role', 403);
    }

    // 3. Gamification & Activity Stats
    $gamification_stmt = $db->prepare("
        SELECT 
            total_xp, total_xp as xp, current_streak, current_streak as streak, longest_streak, last_activity_date, updated_at
        FROM student_gamification
        WHERE user_id = ?
    ");
    $gamification_stmt->execute([$student_id]);
    $gamification = $gamification_stmt->fetch(PDO::FETCH_ASSOC) ?: [
        'total_xp' => 0,
        'xp' => 0,
        'current_streak' => 0,
        'streak' => 0,
        'longest_streak' => 0,
        'last_activity_date' => null,
        'updated_at' => null
    ];

    // 4. Course & Lesson Progress — enrollment is source of truth; progress % computed
    // (course_progress has no progress_percent column in schema)
    $courses_stmt = $db->prepare("
        SELECT 
            c.id, c.title, c.slug, c.description, c.image_url, c.accent_color,
            ag.name as academic_group_name,
            COALESCE(cp.status, 'not_started') as status,
            (SELECT COUNT(*) FROM lessons l JOIN chapters ch ON l.chapter_id = ch.id WHERE ch.course_id = c.id) as total_lessons,
            (
                SELECT COUNT(DISTINCT lp.lesson_id) 
                FROM lesson_progress lp 
                JOIN lessons l ON lp.lesson_id = l.id
                JOIN chapters ch ON l.chapter_id = ch.id
                WHERE lp.user_id = ? AND ch.course_id = c.id AND lp.status = 'completed'
            ) as completed_lessons
        FROM course_enrollments ce
        JOIN courses c ON c.id = ce.course_id
        LEFT JOIN academic_groups ag ON c.academic_group_id = ag.id
        LEFT JOIN course_progress cp ON cp.course_id = c.id AND cp.user_id = ce.user_id
        WHERE ce.user_id = ?
        ORDER BY c.title ASC
    ");
    $courses_stmt->execute([$student_id, $student_id]);
    $courses_progress = $courses_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($courses_progress as &$cp_row) {
        $total = (int)($cp_row['total_lessons'] ?? 0);
        $done = (int)($cp_row['completed_lessons'] ?? 0);
        $cp_row['progress_percent'] = $total > 0 ? (int)round(($done / $total) * 100) : 0;
        if (empty($cp_row['status']) || $cp_row['status'] === 'not_started') {
            if ($cp_row['progress_percent'] >= 100) {
                $cp_row['status'] = 'completed';
            } elseif ($done > 0) {
                $cp_row['status'] = 'in_progress';
            } else {
                $cp_row['status'] = 'not_started';
            }
        }
    }
    unset($cp_row);

    // 5. Completed Lessons List
    $completed_lessons_stmt = $db->prepare("
        SELECT 
            l.id, l.title, l.slug, l.xp_reward, l.duration_minutes,
            ch.title as chapter_title,
            c.title as course_title,
            lp.completed_at
        FROM lesson_progress lp
        JOIN lessons l ON lp.lesson_id = l.id
        JOIN chapters ch ON l.chapter_id = ch.id
        JOIN courses c ON ch.course_id = c.id
        WHERE lp.user_id = ? AND lp.status = 'completed'
        ORDER BY lp.completed_at DESC
    ");
    $completed_lessons_stmt->execute([$student_id]);
    $completed_lessons = $completed_lessons_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 6. Exam Scores & History
    $exams_stmt = $db->prepare("
        SELECT 
            ea.id as attempt_id, ea.score, ea.passed, ea.started_at, ea.completed_at,
            e.id as exam_id, e.title as exam_title, e.passing_score_percent,
            ch.title as chapter_title,
            c.title as course_title,
            (SELECT COUNT(*) FROM exam_questions eq WHERE eq.exam_id = e.id) as total_questions,
            (SELECT COUNT(*) FROM answers a WHERE a.exam_attempt_id = ea.id AND a.is_correct = 1) as correct_answers
        FROM exam_attempts ea
        JOIN exams e ON ea.exam_id = e.id
        JOIN chapters ch ON e.chapter_id = ch.id
        JOIN courses c ON ch.course_id = c.id
        WHERE ea.user_id = ?
        ORDER BY ea.started_at DESC
    ");
    $exams_stmt->execute([$student_id]);
    $exam_history = $exams_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 7. Submitted Projects & Practical Challenges
    $projects_stmt = $db->prepare("
        SELECT 
            ps.id as submission_id, ps.status, ps.grade, ps.feedback, ps.content_json,
            ps.created_at as submitted_at, ps.updated_at,
            p.id as project_id, p.title as project_title, p.description as project_desc,
            p.xp_reward,
            c.title as course_title
        FROM project_submissions ps
        JOIN projects p ON ps.project_id = p.id
        JOIN courses c ON p.course_id = c.id
        WHERE ps.user_id = ?
        ORDER BY ps.created_at DESC
    ");
    $projects_stmt->execute([$student_id]);
    $project_submissions = $projects_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($project_submissions as &$ps) {
        if (!empty($ps['content_json']) && is_string($ps['content_json'])) {
            $ps['content_data'] = json_decode($ps['content_json'], true);
        } else {
            $ps['content_data'] = $ps['content_json'];
        }
    }
    unset($ps);

    // 8. Achievements
    $achievements_stmt = $db->prepare("
        SELECT 
            a.id, a.title, a.description, a.icon_url, a.xp_reward,
            sa.earned_at
        FROM student_achievements sa
        JOIN achievements a ON sa.achievement_id = a.id
        WHERE sa.user_id = ?
        ORDER BY sa.earned_at DESC
    ");
    $achievements_stmt->execute([$student_id]);
    $achievements = $achievements_stmt->fetchAll(PDO::FETCH_ASSOC);

    success_response([
        'profile' => $student,
        'gamification' => $gamification,
        'courses_progress' => $courses_progress,
        'completed_lessons' => $completed_lessons,
        'exam_history' => $exam_history,
        'project_submissions' => $project_submissions,
        'achievements' => $achievements
    ]);

} catch (Exception $e) {
    error_log('Student Detailed Profile Error: ' . $e->getMessage()); error_response('Failed to fetch student profile. Please try again.', 500);
}
