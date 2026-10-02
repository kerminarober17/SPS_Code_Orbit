<?php
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_get_method();
// Secrets-based admin session OR (legacy) role admin
$user = null;
if (function_exists('is_admin_session') && is_admin_session()) {
    $user = current_user();
} else {
    $user = require_auth(['admin']);
}
if (!$user || (($user['role'] ?? '') !== 'admin' && !is_admin_session())) {
    error_response('Forbidden. Admin access required.', 403);
}

$ALLOWED_STAGES = ['Primary', 'Prep', 'Preparatory', 'Secondary'];
$ALLOWED_CLASSES = ['A', 'B', 'C', 'A2', 'D', 'E', 'E2'];

function derive_stage_from_group(?string $group_name): ?string {
    if ($group_name === null || $group_name === '') return null;
    $n = strtolower(trim($group_name));
    if (strpos($n, 'primary') !== false) return 'Primary';
    if (strpos($n, 'preparat') !== false || $n === 'prep' || strpos($n, 'prep ') === 0) return 'Prep';
    if (strpos($n, 'second') !== false) return 'Secondary';
    return null;
}

/** Extract class letter from legacy class name e.g. "Class Prep 1 - A" → "A" */
function extract_class_letter(?string $name): ?string {
    if ($name === null || $name === '') return null;
    $n = trim($name);
    $allowed = ['A', 'B', 'C', 'A2', 'D', 'E', 'E2'];
    $up = strtoupper($n);
    if (in_array($up, $allowed, true)) return $up;
    if (preg_match('/\b(A2|E2|[A-E])\s*$/i', $n, $m)) {
        $letter = strtoupper($m[1]);
        if (in_array($letter, $allowed, true)) return $letter;
    }
    if (preg_match('/[-–]\s*(A2|E2|[A-E])\s*$/i', $n, $m)) {
        $letter = strtoupper($m[1]);
        if (in_array($letter, $allowed, true)) return $letter;
    }
    return null;
}

try {
    $db = get_db_connection();

    $academic_stage = trim($_GET['academic_stage'] ?? $_GET['stage'] ?? '');
    $class_filter = trim($_GET['class'] ?? $_GET['class_section'] ?? $_GET['class_id'] ?? '');
    $search = trim($_GET['search'] ?? '');

    // Normalize filters
    $stage_filter = '';
    $s = strtolower($academic_stage);
    if ($s === 'primary' || strpos($s, 'primary') !== false) $stage_filter = 'Primary';
    elseif ($s === 'preparatory' || strpos($s, 'preparat') !== false || $s === 'prep') $stage_filter = 'Prep';
    elseif ($s === 'secondary' || strpos($s, 'second') !== false) $stage_filter = 'Secondary';

    $class_letter_filter = '';
    if ($class_filter !== '') {
        $cl = strtoupper(preg_replace('/^class\s+/i', '', $class_filter));
        if (preg_match('/^([A-E])2$/i', $cl, $m)) $cl = strtoupper($m[1]) . '2';
        if (in_array($cl, $ALLOWED_CLASSES, true)) {
            $class_letter_filter = $cl;
        } elseif (preg_match('/^[0-9a-f-]{36}$/i', $class_filter)) {
            // legacy UUID class_id filter — keep for backward compat
            $class_letter_filter = '';
            $legacy_class_id = $class_filter;
        }
    }
    $legacy_class_id = $legacy_class_id ?? '';

    $has_users_table = false;
    try {
        if ($db->query("SHOW TABLES LIKE 'users'")->fetch()) $has_users_table = true;
    } catch (\Throwable $e) {}

    $profile_cols = [];
    try {
        $profile_cols = $db->query("SHOW COLUMNS FROM profiles")->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (\Throwable $e) {}

    $has_stage_col = in_array('academic_stage', $profile_cols, true);
    $has_section_col = in_array('class_section', $profile_cols, true);
    $has_grade_col = in_array('grade_level', $profile_cols, true);
    $has_year_col = in_array('academic_year', $profile_cols, true);

    $email_select = $has_users_table
        ? "COALESCE(u.email, p.email, '') as email"
        : "COALESCE(p.email, '') as email";
    $user_join = $has_users_table ? "LEFT JOIN users u ON u.id = p.id" : "";

    $username_select = in_array('username', $profile_cols) ? 'p.username' : "'' as username";
    $avatar_select = in_array('avatar_url', $profile_cols) ? 'p.avatar_url' : "'' as avatar_url";
    $xp_select = in_array('xp', $profile_cols) ? 'COALESCE(sg.total_xp, p.xp, 0) as total_xp' : 'COALESCE(sg.total_xp, 0) as total_xp';

    $stage_select = $has_stage_col ? 'p.academic_stage as academic_stage_col' : 'NULL as academic_stage_col';
    $section_select = $has_section_col ? 'p.class_section as class_section_col' : 'NULL as class_section_col';
    $grade_select = $has_grade_col ? 'p.grade_level as grade_level_col' : ($has_year_col ? 'p.academic_year as grade_level_col' : 'NULL as grade_level_col');

    $query = "
        SELECT 
            p.id, {$username_select}, p.full_name, {$email_select}, {$avatar_select}, p.created_at,
            c.id as class_id, c.name as class_name_raw,
            g.id as grade_id, g.name as grade_name,
            ag.id as academic_group_id, ag.name as academic_group_name,
            {$stage_select},
            {$section_select},
            {$grade_select},
            {$xp_select},
            COALESCE(sg.current_streak, 0) as current_streak,
            COALESCE(sg.longest_streak, 0) as longest_streak,
            sg.last_activity_date,
            (SELECT COUNT(*) FROM lesson_progress lp WHERE lp.user_id = p.id AND lp.status = 'completed') as completed_lessons_count,
            (SELECT COUNT(*) FROM exam_attempts ea WHERE ea.user_id = p.id) as exam_attempts_count,
            (SELECT COUNT(*) FROM project_submissions ps WHERE ps.user_id = p.id) as project_submissions_count,
            (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.student_id = p.id AND cs.is_active = 1) as challenge_submissions_count,
            (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.student_id = p.id AND cs.is_active = 1 AND cs.status = 'pending') as challenge_pending_count,
            (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.student_id = p.id AND cs.is_active = 1 AND cs.status = 'approved') as challenge_approved_count,
            (SELECT COUNT(*) FROM challenge_submissions cs WHERE cs.student_id = p.id AND cs.is_active = 1 AND cs.status = 'rejected') as challenge_rejected_count,
            (SELECT COUNT(DISTINCT cs.challenge_id) FROM challenge_submissions cs WHERE cs.student_id = p.id AND cs.is_active = 1) as challenges_attempted_count,
            (SELECT COUNT(*) FROM course_enrollments ce WHERE ce.user_id = p.id) as enrollments_count
        FROM profiles p
        {$user_join}
        LEFT JOIN classes c ON p.class_id = c.id
        LEFT JOIN grades g ON c.grade_id = g.id
        LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id
        LEFT JOIN student_gamification sg ON sg.user_id = p.id
        WHERE p.role = 'student'
    ";

    $params = [];

    if ($search !== '') {
        $username_search = in_array('username', $profile_cols) ? "OR p.username LIKE ?" : "";
        $email_search = $has_users_table ? "OR u.email LIKE ?" : "";
        $query .= " AND (p.full_name LIKE ? {$username_search} {$email_search})";
        $searchTerm = "%{$search}%";
        $params[] = $searchTerm;
        if ($username_search) $params[] = $searchTerm;
        if ($email_search) $params[] = $searchTerm;
    }

    // Prefer filtering on new columns when present
    if ($stage_filter !== '') {
        if ($has_stage_col) {
            if ($stage_filter === 'Prep' || $stage_filter === 'Preparatory') {
                $query .= " AND (p.academic_stage = 'Prep' OR p.academic_stage = 'Preparatory')";
            } else {
                $query .= " AND p.academic_stage = ?";
                $params[] = $stage_filter;
            }
        } else {
            if ($stage_filter === 'Primary') {
                $query .= " AND ag.name LIKE ?";
                $params[] = 'Primary%';
            } elseif ($stage_filter === 'Prep' || $stage_filter === 'Preparatory') {
                $query .= " AND (ag.name LIKE ? OR ag.name LIKE ? OR LOWER(ag.name) = ?)";
                $params[] = 'Preparat%';
                $params[] = 'Prep%';
                $params[] = 'preparatory';
            } elseif ($stage_filter === 'Secondary') {
                $query .= " AND ag.name LIKE ?";
                $params[] = 'Second%';
            }
        }
    }

    if ($class_letter_filter !== '') {
        if ($has_section_col) {
            $query .= " AND UPPER(p.class_section) = ?";
            $params[] = $class_letter_filter;
        } else {
            // legacy: match class name ending with letter
            $query .= " AND (c.name LIKE ? OR c.name LIKE ? OR UPPER(TRIM(c.name)) = ?)";
            $params[] = '% - ' . $class_letter_filter;
            $params[] = '% ' . $class_letter_filter;
            $params[] = $class_letter_filter;
        }
    } elseif ($legacy_class_id !== '') {
        $query .= " AND c.id = ?";
        $params[] = $legacy_class_id;
    }

    $query .= " ORDER BY p.full_name ASC";

    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $students = [];
    foreach ($rows as $r) {
        // Authoritative stage
        $stage = null;
        if (!empty($r['academic_stage_col'])) {
            $stage = $r['academic_stage_col'];
        } else {
            $stage = derive_stage_from_group($r['academic_group_name'] ?? null);
        }
        if ($stage && stripos($stage, 'preparat') !== false) {
            $stage = 'Prep';
        }

        // Authoritative class letter
        $section = null;
        if (!empty($r['class_section_col'])) {
            $section = strtoupper(trim($r['class_section_col']));
        } else {
            $section = extract_class_letter($r['class_name_raw'] ?? null);
        }

        $students[] = [
            'id' => $r['id'],
            'username' => $r['username'] ?? '',
            'full_name' => $r['full_name'],
            'email' => $r['email'] ?? '',
            'avatar_url' => $r['avatar_url'] ?? '',
            'created_at' => $r['created_at'] ?? null,
            'class_id' => $r['class_id'] ?? null,
            'academic_stage' => $stage,
            'class_section' => $section,
            'grade_level' => $r['grade_level_col'] ?? null,
            'display_class' => trim(($r['grade_level_col'] ?? '') . ((!empty($r['grade_level_col']) && !empty($section)) ? ' - ' : '') . ($section ?? '')),
            'class_name' => trim(($r['grade_level_col'] ?? '') . ((!empty($r['grade_level_col']) && !empty($section)) ? ' - ' : '') . ($section ?? '')) ?: $section, // e.g. "3 Prep - A"
            'grade_id' => $r['grade_id'] ?? null,
            'grade_name' => $r['grade_level_col'] ?? ($r['grade_name'] ?? null),
            'academic_group_id' => $r['academic_group_id'] ?? null,
            'academic_group_name' => $r['academic_group_name'] ?? null,
            'total_xp' => $r['total_xp'] ?? 0,
            'current_streak' => $r['current_streak'] ?? 0,
            'longest_streak' => $r['longest_streak'] ?? 0,
            'last_activity_date' => $r['last_activity_date'] ?? null,
            'completed_lessons_count' => $r['completed_lessons_count'] ?? 0,
            'exam_attempts_count' => $r['exam_attempts_count'] ?? 0,
            'project_submissions_count' => $r['project_submissions_count'] ?? 0,
            'challenge_submissions_count' => $r['challenge_submissions_count'] ?? 0,
            'challenge_pending_count' => $r['challenge_pending_count'] ?? 0,
            'challenge_approved_count' => $r['challenge_approved_count'] ?? 0,
            'challenge_rejected_count' => $r['challenge_rejected_count'] ?? 0,
            'challenges_attempted_count' => $r['challenges_attempted_count'] ?? 0,
            'enrollments_count' => $r['enrollments_count'] ?? 0,
        ];
    }

    // Fixed Class filter options for Admin UI
    $classes = array_map(function ($c) {
        return ['id' => $c, 'name' => $c, 'value' => $c];
    }, $ALLOWED_CLASSES);

    $stages = [
        ['value' => '', 'label' => 'All'],
        ['value' => 'Primary', 'label' => 'Primary'],
        ['value' => 'Prep', 'label' => 'Prep'],
        ['value' => 'Secondary', 'label' => 'Secondary'],
    ];

    success_response([
        'students' => $students,
        'stages' => $stages,
        'classes' => $classes,
        'academic_groups' => [],
        'grades' => [],
        'filters' => [
            'academic_stage' => $stage_filter,
            'class' => $class_letter_filter,
            'search' => $search,
        ],
    ]);

} catch (\Throwable $e) {
    error_log('Admin Students API Error: ' . $e->getMessage());
    json_response([
        'status' => 'error',
        'success' => false,
        'message' => 'Failed to fetch students. Please try again.',
        'error' => 'server_error'
    ], 200);
}
