<?php
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
$user = require_auth(['admin', 'teacher']);

$student_id = trim($_GET['student_id'] ?? $_GET['id'] ?? '');

if (empty($student_id)) {
    json_response([
        'status' => 'error',
        'success' => false,
        'message' => 'student_id parameter is required'
    ], 200);
    exit;
}

try {
    $db = get_db_connection();

    // Check if separate users table exists
    $has_users_table = false;
    try {
        $u_res = $db->query("SHOW TABLES LIKE 'users'")->fetch();
        if ($u_res) $has_users_table = true;
    } catch (\Throwable $e) {}

    // Prefer users.email when separate users table exists; otherwise profiles.email (schema includes it)
    $email_select = $has_users_table
        ? "COALESCE(u.email, p.email, '') as email"
        : "COALESCE(p.email, '') as email";
    $user_join = $has_users_table ? "LEFT JOIN users u ON u.id = p.id" : "";

    // 1. Fetch student basic profile from real MySQL rows
    $profile_stmt = $db->prepare("
        SELECT 
            p.id, p.id as user_id, p.username, p.full_name, p.role, p.avatar_url, p.created_at,
            {$email_select},
            c.id as class_id, c.name as class_name, c.name as class_group,
            g.id as grade_id, g.name as grade_name,
            ag.id as academic_group_id, ag.name as academic_group_name
        FROM profiles p
        {$user_join}
        LEFT JOIN classes c ON p.class_id = c.id
        LEFT JOIN grades g ON c.grade_id = g.id
        LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id
        WHERE p.id = :student_id AND p.role = 'student'
        LIMIT 1
    ");
    $profile_stmt->execute([':student_id' => $student_id]);
    
    $student = $profile_stmt->fetch(PDO::FETCH_ASSOC);

    // Derive Academic Stage from academic_group_name
    if ($student) {
        $gn = strtolower(trim((string)($student['academic_group_name'] ?? '')));
        if (strpos($gn, 'primary') !== false) {
            $student['academic_stage'] = 'Primary';
        } elseif (strpos($gn, 'preparat') !== false || $gn === 'prep' || strpos($gn, 'prep ') === 0) {
            $student['academic_stage'] = 'Prep';
        } elseif (strpos($gn, 'second') !== false) {
            $student['academic_stage'] = 'Secondary';
        } else {
            $student['academic_stage'] = $student['academic_group_name'] ?? null;
        }
    }

    if (!$student) {
        // Try without role check in case profile role is stored differently
        $profile_stmt2 = $db->prepare("
            SELECT 
                p.id, p.id as user_id, p.username, p.full_name, p.role, p.avatar_url, p.created_at,
                {$email_select},
                c.id as class_id, c.name as class_name, c.name as class_group,
                g.id as grade_id, g.name as grade_name,
                ag.id as academic_group_id, ag.name as academic_group_name
            FROM profiles p
            {$user_join}
            LEFT JOIN classes c ON p.class_id = c.id
            LEFT JOIN grades g ON c.grade_id = g.id
            LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id
            WHERE p.id = :student_id
            LIMIT 1
        ");
        $profile_stmt2->execute([':student_id' => $student_id]);
        $student = $profile_stmt2->fetch(PDO::FETCH_ASSOC);
    }

    if (!$student) {
        json_response([
            'status' => 'error',
            'success' => false,
            'message' => 'Student record not found in system'
        ], 200);
        exit;
    }

    // Resolve Academic Stage + Class section letter
    // Prefer columns academic_stage / class_section when present on the row
    $profile_cols = [];
    try {
        $profile_cols = $db->query("SHOW COLUMNS FROM profiles")->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (\Throwable $e) {}

    if (in_array('academic_stage', $profile_cols, true) || in_array('class_section', $profile_cols, true) || in_array('grade_level', $profile_cols, true) || in_array('academic_year', $profile_cols, true)) {
        try {
            $extra_cols = [];
            if (in_array('academic_stage', $profile_cols, true)) $extra_cols[] = 'academic_stage';
            if (in_array('class_section', $profile_cols, true)) $extra_cols[] = 'class_section';
            if (in_array('grade_level', $profile_cols, true)) $extra_cols[] = 'grade_level';
            if (in_array('academic_year', $profile_cols, true)) $extra_cols[] = 'academic_year';
            $extra = $db->prepare('SELECT ' . implode(', ', $extra_cols) . ' FROM profiles WHERE id = ? LIMIT 1');
            $extra->execute([$student['id']]);
            $ex = $extra->fetch(PDO::FETCH_ASSOC);
            if ($ex) {
                if (!empty($ex['academic_stage'])) $student['academic_stage'] = $ex['academic_stage'];
                if (!empty($ex['class_section'])) {
                    $student['class_section'] = $ex['class_section'];
                }
                $gl = $ex['grade_level'] ?? $ex['academic_year'] ?? null;
                if (!empty($gl)) {
                    $student['grade_level'] = $gl;
                }
                $sec = $student['class_section'] ?? '';
                $student['display_class'] = trim(($gl ?? '') . ((!empty($gl) && $sec !== '') ? ' - ' : '') . $sec);
                $student['class_name'] = $student['display_class'] ?: $sec;
            }
        } catch (\Throwable $e) {}
    }

    if (empty($student['academic_stage'])) {
        $gn = strtolower(trim((string)($student['academic_group_name'] ?? '')));
        if (strpos($gn, 'primary') !== false) {
            $student['academic_stage'] = 'Primary';
        } elseif (strpos($gn, 'preparat') !== false || $gn === 'prep' || strpos($gn, 'prep ') === 0) {
            $student['academic_stage'] = 'Prep';
        } elseif (strpos($gn, 'second') !== false) {
            $student['academic_stage'] = 'Secondary';
        } else {
            $student['academic_stage'] = $student['academic_group_name'] ?? null;
        }
    }

    if (empty($student['class_section']) && !empty($student['class_name'])) {
        $cn = trim((string)$student['class_name']);
        $allowed = ['A', 'B', 'C', 'A2', 'D', 'E', 'E2'];
        $up = strtoupper($cn);
        if (in_array($up, $allowed, true)) {
            $student['class_section'] = $up;
            $student['class_name'] = $up;
        } elseif (preg_match('/\b(A2|E2|[A-E])\s*$/i', $cn, $m)) {
            $letter = strtoupper($m[1]);
            if (in_array($letter, $allowed, true)) {
                $student['class_section'] = $letter;
                $student['class_name'] = $letter;
            }
        }
    }

    // 2. Gamification & Activity Stats
    $gamification = [
        'total_xp' => 0,
        'xp' => 0,
        'current_streak' => 0,
        'streak' => 0,
        'longest_streak' => 0,
        'last_activity_date' => null
    ];
    try {
        $gamification_stmt = $db->prepare("
            SELECT 
                total_xp, total_xp as xp, current_streak, current_streak as streak, longest_streak, last_activity_date
            FROM student_gamification
            WHERE user_id = ?
            LIMIT 1
        ");
        $gamification_stmt->execute([$student_id]);
        $g_row = $gamification_stmt->fetch(PDO::FETCH_ASSOC);
        if ($g_row) {
            $gamification = $g_row;
        }
    } catch (\Throwable $e) {}

    // 3. Course & Lesson Progress — enrollment is the source of truth.
    // course_progress has no progress_percent column; compute % from lesson_progress.
    $courses_progress = [];
    try {
        $courses_stmt = $db->prepare("
            SELECT 
                c.id, c.title, c.slug, c.description, c.image_url, c.accent_color,
                ag.name as academic_group_name,
                COALESCE(cp.status, 'not_started') as status,
                ce.created_at as enrolled_at,
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
    } catch (\Throwable $e) {
        error_log('Admin student courses_progress: ' . $e->getMessage());
        $courses_progress = [];
    }

    // 4. Completed Lessons List
    $completed_lessons = [];
    try {
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
    } catch (\Throwable $e) {}

    // 5. Exam Scores & History
    $exam_history = [];
    try {
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
            LEFT JOIN chapters ch ON e.chapter_id = ch.id
            LEFT JOIN courses c ON ch.course_id = c.id
            WHERE ea.user_id = ?
            ORDER BY ea.started_at DESC
        ");
        $exams_stmt->execute([$student_id]);
        $exam_history = $exams_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}

    // 6. Submitted Projects
    $project_submissions = [];
    try {
        $projects_stmt = $db->prepare("
            SELECT 
                ps.id as submission_id, ps.status, ps.grade, ps.feedback, ps.content_json,
                ps.created_at as submitted_at, ps.updated_at,
                p.id as project_id, p.title as project_title, p.description as project_desc,
                p.xp_reward,
                c.title as course_title
            FROM project_submissions ps
            JOIN projects p ON ps.project_id = p.id
            LEFT JOIN courses c ON p.course_id = c.id
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
    } catch (\Throwable $e) {}

    // 7. Achievements
    $achievements = [];
    try {
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
    } catch (\Throwable $e) {}

    // 8. Challenge submissions (active only; one row per attempt history)
    $challenge_submissions = [];
    try {
        $ch_stmt = $db->prepare("
            SELECT
                cs.id AS submission_id,
                cs.challenge_id,
                cs.status,
                cs.feedback,
                cs.score,
                cs.submitted_at,
                cs.reviewed_at,
                cs.attempt_number,
                cs.file_original_name,
                cs.file_type,
                cs.file_size,
                ch.title AS challenge_title,
                rev.full_name AS reviewer_name
            FROM challenge_submissions cs
            JOIN challenges ch ON cs.challenge_id = ch.id
            LEFT JOIN profiles rev ON cs.reviewed_by = rev.id
            WHERE cs.student_id = ?
            ORDER BY cs.submitted_at DESC
            LIMIT 50
        ");
        $ch_stmt->execute([$student_id]);
        $challenge_submissions = $ch_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}

    success_response([
        'profile' => $student,
        'gamification' => $gamification,
        'courses_progress' => $courses_progress,
        'completed_lessons' => $completed_lessons,
        'exam_history' => $exam_history,
        'project_submissions' => $project_submissions,
        'challenge_submissions' => $challenge_submissions,
        'achievements' => $achievements
    ]);

} catch (\Throwable $e) {
    error_log('Admin Get Student Profile Error: ' . $e->getMessage());
    json_response([
        'status' => 'error',
        'success' => false,
        'message' => 'Failed to fetch student profile. Please try again.'
    ], 200);
}
