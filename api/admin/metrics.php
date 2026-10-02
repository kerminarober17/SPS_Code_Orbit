<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/admin.php';

require_get_method();
$user = require_admin();

try {
    $db = get_db_connection();

    // Counts — all from real MySQL rows (no placeholders)
    $students_count = (int)$db->query("SELECT COUNT(*) FROM profiles WHERE role = 'student'")->fetchColumn();
    $teachers_count = (int)$db->query("SELECT COUNT(*) FROM profiles WHERE role = 'teacher'")->fetchColumn();
    $courses_count = (int)$db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
    $published_courses_count = (int)$db->query("SELECT COUNT(*) FROM courses WHERE is_published = 1")->fetchColumn();
    $lessons_count = (int)$db->query("SELECT COUNT(*) FROM lessons")->fetchColumn();
    $classes_count = (int)$db->query("SELECT COUNT(*) FROM classes")->fetchColumn();
    $completions_count = (int)$db->query("SELECT COUNT(*) FROM lesson_progress WHERE status = 'completed'")->fetchColumn();
    $projects_submitted_count = (int)$db->query("SELECT COUNT(*) FROM project_submissions")->fetchColumn();
    $exams_completed_count = (int)$db->query("SELECT COUNT(*) FROM exam_attempts WHERE completed_at IS NOT NULL OR score IS NOT NULL")->fetchColumn();
    $total_exams_count = (int)$db->query("SELECT COUNT(*) FROM exams")->fetchColumn();
    $total_projects_count = (int)$db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    // Unique enrolled students across all courses (learners)
    $total_enrollments = (int)$db->query("SELECT COUNT(*) FROM course_enrollments")->fetchColumn();
    $unique_enrolled_students = (int)$db->query("SELECT COUNT(DISTINCT user_id) FROM course_enrollments")->fetchColumn();

    // Challenge system metrics (real challenge_submissions table)
    $challenge_submissions_count = 0;
    $challenge_pending_count = 0;
    $challenges_published_count = 0;
    try {
        $challenge_submissions_count = (int)$db->query("SELECT COUNT(*) FROM challenge_submissions WHERE is_active = 1")->fetchColumn();
        $challenge_pending_count = (int)$db->query("SELECT COUNT(*) FROM challenge_submissions WHERE is_active = 1 AND status = 'pending'")->fetchColumn();
        $challenges_published_count = (int)$db->query("SELECT COUNT(*) FROM challenges WHERE is_published = 1 AND is_archived = 0")->fetchColumn();
    } catch (Exception $ignore) {
        // challenges tables may not exist on older installs
    }

    // All courses with accurate distinct learner counts (not limited to recent 10)
    $courses_stmt = $db->query("
        SELECT c.id, c.title, c.slug, c.is_published, c.created_at,
               ag.name as academic_group_name,
               (SELECT COUNT(*) FROM chapters ch WHERE ch.course_id = c.id) as chapters_count,
               (SELECT COUNT(*) FROM lessons l JOIN chapters ch ON l.chapter_id = ch.id WHERE ch.course_id = c.id) as lessons_count,
               (SELECT COUNT(DISTINCT ce.user_id) FROM course_enrollments ce WHERE ce.course_id = c.id) as students_enrolled
        FROM courses c
        LEFT JOIN academic_groups ag ON c.academic_group_id = ag.id
        ORDER BY c.title ASC
    ");
    $recent_courses = $courses_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recent registrations
    $users_stmt = $db->query("
        SELECT p.id, p.username, p.full_name, p.role, p.created_at, cl.name as class_name
        FROM profiles p
        LEFT JOIN classes cl ON p.class_id = cl.id
        ORDER BY p.created_at DESC
        LIMIT 10
    ");
    $recent_users = $users_stmt->fetchAll();

    $metrics = [
        'total_students' => $students_count,
        'total_teachers' => $teachers_count,
        'total_courses' => $courses_count,
        'published_courses' => $published_courses_count,
        'total_lessons' => $lessons_count,
        'total_classes' => $classes_count,
        'total_completions' => $completions_count,
        'completed_lessons' => $completions_count,
        'total_projects_submitted' => $projects_submitted_count,
        'total_exams_completed' => $exams_completed_count,
        'total_exams' => $total_exams_count,
        'total_projects' => $total_projects_count,
        'total_enrollments' => $total_enrollments,
        'unique_enrolled_students' => $unique_enrolled_students,
        // Alias used by dashboard "TOTAL ENROLLED STUDENTS" card
        'total_enrolled_students' => $unique_enrolled_students,
        'challenge_submissions' => $challenge_submissions_count,
        'challenge_pending' => $challenge_pending_count,
        'challenges_published' => $challenges_published_count,
    ];

    success_response(array_merge($metrics, [
        'metrics' => $metrics,
        'courses' => $recent_courses,
        'users' => $recent_users
    ]));

} catch (Exception $e) {
    error_log('Admin Metrics Error: ' . $e->getMessage());
    error_response('Failed to fetch admin metrics. Please try again.', 500);
}
