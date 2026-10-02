<?php
/**
 * Student signup
 * Required: full_name, username, password, academic_stage, grade_level, class (letter)
 * Academic Stage: Primary | Preparatory | Secondary
 * Class: A | B | C | A2 | D | E | E2
 * Stored on profiles.academic_stage + profiles.grade_level + profiles.class_section
 * class_id left NULL unless a matching classes row is found (non-blocking)
 */
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/auth.php';

require_post_method();

$data = get_json_request();
if (empty($data) && !empty($_POST)) {
    $data = $_POST;
}

$full_name = trim($data['full_name'] ?? '');
$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';
$password_confirm = $data['password_confirm'] ?? $data['password'] ?? '';

$academic_stage = trim($data['academic_stage'] ?? $data['academic_level'] ?? $data['academic_group'] ?? '');
$grade_level = trim($data['grade_level'] ?? $data['grade'] ?? $data['academic_year'] ?? $data['year'] ?? '');
$academic_year = $grade_level; // backward-compat alias
// Class letter — accept several field names
$class_section = trim($data['class'] ?? $data['class_section'] ?? $data['class_id'] ?? '');

// Normalize stage
$allowed_stages = ['Primary', 'Prep', 'Preparatory', 'Secondary'];
$stage_map = [
    'primary' => 'Primary',
    'preparatory' => 'Prep',
    'prep' => 'Prep',
    'secondary' => 'Secondary',
    'sec' => 'Secondary',
];
$stage_key = strtolower($academic_stage);
if (isset($stage_map[$stage_key])) {
    $academic_stage = $stage_map[$stage_key];
}

// Normalize class letter (strip "Class " prefix if present)
$class_section = preg_replace('/^class\s+/i', '', $class_section);
$class_section = strtoupper(trim($class_section));
// Allow A2, E2 as mixed case was uppercased — fix digit forms
if (preg_match('/^([A-E])2$/i', $class_section, $m)) {
    $class_section = strtoupper($m[1]) . '2';
}
$allowed_classes = ['A', 'B', 'C', 'A2', 'D', 'E', 'E2'];

if ($full_name === '') {
    error_response('Full name is required', 400);
}
if (strlen($full_name) > 100) {
    error_response('Full name must not exceed 100 characters', 400);
}
if ($username === '') {
    error_response('Username is required', 400);
}
if (strlen($username) < 3) {
    error_response('Username must be at least 3 characters', 400);
}
if (strlen($username) > 50) {
    error_response('Username must not exceed 50 characters', 400);
}
if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
    error_response('Username can only contain letters, numbers, underscores, dots, and hyphens', 400);
}
if ($password === '') {
    error_response('Password is required', 400);
}
if (strlen($password) < 8) {
    error_response('Password must be at least 8 characters', 400);
}
if ($password !== $password_confirm) {
    error_response('Passwords do not match', 400);
}
if ($academic_stage === '' || !in_array($academic_stage, $allowed_stages, true)) {
    error_response('Academic Stage is required. Choose Primary, Preparatory, or Secondary.', 400);
}
if ($class_section === '' || !in_array($class_section, $allowed_classes, true)) {
    error_response('Class is required. Choose one of: A, B, C, A2, D, E, E2.', 400);
}
$grades_by_stage = [
    'Primary' => ['1 Prim', '2 Prim', '3 Prim', '4 Prim', '5 Prim', '6 Prim'],
    'Prep' => ['1 Prep', '2 Prep', '3 Prep'],
    'Preparatory' => ['1 Prep', '2 Prep', '3 Prep'],
    'Secondary' => ['1 Sec', '2 Sec', '3 Sec'],
];
$allowed_grades = array_merge($grades_by_stage['Primary'], $grades_by_stage['Preparatory'], $grades_by_stage['Secondary']);
// Normalize common variants
$grade_norm_map = [
    '1st primary' => '1 Prim', '2nd primary' => '2 Prim', '3rd primary' => '3 Prim',
    '4th primary' => '4 Prim', '5th primary' => '5 Prim', '6th primary' => '6 Prim',
    '1st prep' => '1 Prep', '2nd prep' => '2 Prep', '3rd prep' => '3 Prep',
    '1st preparatory' => '1 Prep', '2nd preparatory' => '2 Prep', '3rd preparatory' => '3 Prep',
    '1st sec' => '1 Sec', '2nd sec' => '2 Sec', '3rd sec' => '3 Sec',
    '1st secondary' => '1 Sec', '2nd secondary' => '2 Sec', '3rd secondary' => '3 Sec',
];
$gk = strtolower(trim($grade_level));
if (isset($grade_norm_map[$gk])) {
    $grade_level = $grade_norm_map[$gk];
}
if ($grade_level === '' || !in_array($grade_level, $allowed_grades, true)) {
    error_response('Grade Level is required. Choose a grade matching the selected stage (e.g. 3 Prep, 1 Sec, 5 Prim).', 400);
}
// Enforce grade belongs to stage
$stage_grades = $grades_by_stage[$academic_stage] ?? [];
if (!in_array($grade_level, $stage_grades, true)) {
    error_response('Selected grade does not belong to the selected academic stage.', 400);
}
if ($academic_stage === 'Preparatory') { $academic_stage = 'Prep'; }
$academic_year = $grade_level;

try {
    $db = get_db_connection();

    $stmt = $db->prepare('SELECT id FROM profiles WHERE LOWER(username) = LOWER(?) LIMIT 1');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        error_response('Username is already taken. Please choose another.', 400);
    }

    // Detect whether new columns exist (graceful if migration not yet applied)
    $profile_cols = [];
    try {
        $profile_cols = $db->query("SHOW COLUMNS FROM profiles")->fetchAll(PDO::FETCH_COLUMN);
    } catch (\Throwable $e) {
        $profile_cols = [];
    }
    $has_stage_col = in_array('academic_stage', $profile_cols, true);
    $has_section_col = in_array('class_section', $profile_cols, true);
    $has_year_col = in_array('academic_year', $profile_cols, true);
    $has_grade_col = in_array('grade_level', $profile_cols, true);
    $has_is_active = in_array('is_active', $profile_cols, true);

    // Optional: try to link class_id if a classes row matches stage + letter
    $class_id = null;
    try {
        $stmt = $db->prepare("
            SELECT c.id
            FROM classes c
            INNER JOIN grades g ON g.id = c.grade_id
            INNER JOIN academic_groups ag ON ag.id = g.academic_group_id
            WHERE (
                UPPER(TRIM(c.name)) = ?
                OR UPPER(TRIM(c.name)) = ?
                OR c.name LIKE ?
                OR c.name LIKE ?
              )
              AND (
                (? = 'Primary' AND ag.name LIKE 'Primary%')
                OR ((? = 'Prep' OR ? = 'Preparatory') AND (ag.name LIKE 'Preparat%' OR ag.name LIKE 'Prep%' OR LOWER(ag.name) IN ('preparatory','prep')))
                OR (? = 'Secondary' AND ag.name LIKE 'Second%')
              )
            LIMIT 1
        ");
        $stmt->execute([
            $class_section,
            'CLASS ' . $class_section,
            '% - ' . $class_section,
            '% ' . $class_section,
            $academic_stage,
            $academic_stage,
            $academic_stage,
            $academic_stage,
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $class_id = $row['id'];
        }
    } catch (\Throwable $ignore) {
        $class_id = null;
    }

    $id = generate_uuid_v4();
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $db->beginTransaction();

    // Build INSERT dynamically based on available columns
    $cols = ['id', 'username', 'password_hash', 'full_name', 'role'];
    $placeholders = ['?', '?', '?', '?', '?'];
    $values = [$id, $username, $password_hash, $full_name, 'student'];

    if ($has_is_active) {
        $cols[] = 'is_active';
        $placeholders[] = '?';
        $values[] = 1;
    }
    $cols[] = 'class_id';
    $placeholders[] = '?';
    $values[] = $class_id;

    if ($has_stage_col) {
        $cols[] = 'academic_stage';
        $placeholders[] = '?';
        $values[] = $academic_stage;
    }
    if ($has_section_col) {
        $cols[] = 'class_section';
        $placeholders[] = '?';
        $values[] = $class_section;
    }
    if ($has_grade_col) {
        $cols[] = 'grade_level';
        $placeholders[] = '?';
        $values[] = $grade_level;
    }
    if ($has_year_col) {
        // Legacy column: store grade code (not calendar year)
        $cols[] = 'academic_year';
        $placeholders[] = '?';
        $values[] = $grade_level;
    }

    $sql = 'INSERT INTO profiles (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $placeholders) . ')';
    $ins = $db->prepare($sql);
    $ins->execute($values);

    try {
        $gam_id = generate_uuid_v4();
        $db->prepare('
            INSERT INTO student_gamification (id, user_id, total_xp, current_streak, longest_streak, last_activity_date)
            VALUES (?, ?, 0, 0, 0, NULL)
        ')->execute([$gam_id, $id]);
    } catch (Exception $ignore) {
    }

    $db->commit();

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_regenerate_id(true);
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['role'] = 'student';
    $_SESSION['class_id'] = $class_id;
    $_SESSION['academic_stage'] = $academic_stage;
    $_SESSION['class_section'] = $class_section;
    $_SESSION['academic_year'] = $grade_level;
    $_SESSION['grade_level'] = $grade_level;
    $_SESSION['avatar_url'] = null;
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    success_response([
        'message' => 'Registration successful',
        'user' => [
            'id' => $id,
            'username' => $username,
            'full_name' => $full_name,
            'role' => 'student',
            'class_id' => $class_id,
            'academic_stage' => $academic_stage,
            'academic_year' => $grade_level,
            'grade_level' => $grade_level,
            'class_section' => $class_section,
            'class_name' => $class_section,
            'avatar_url' => null
        ],
        'csrf_token' => $_SESSION['csrf_token']
    ], 201);

} catch (PDOException $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log('Signup PDO Error: ' . $e->getMessage());
    error_response('Registration is temporarily unavailable. Please try again later.', 503);
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log('Signup Server Error: ' . $e->getMessage());
    $msg = $e->getMessage();
    if (stripos($msg, 'Database connection') !== false || stripos($msg, 'Database configuration') !== false) {
        error_response('Registration is temporarily unavailable. Please try again later.', 503);
    }
    error_response('Server error during registration. Please try again.', 500);
}
