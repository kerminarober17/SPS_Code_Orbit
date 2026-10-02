<?php
/**
 * Student profile — GET profile/stats/badges; POST updates preferred_language.
 * Fully defensive: missing columns/tables never cause HTTP 500.
 */
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/student.php';
require_once __DIR__ . '/../../middleware/csrf.php';

try {
    $user = require_student();
} catch (Throwable $e) {
    error_log('profile.php auth: ' . $e->getMessage());
    error_response('Unauthorized', 401);
}

$user_id = $user['id'];
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    $db = get_db_connection();

    // ── POST ──────────────────────────────────────────────────────────────
    if ($method === 'POST') {
        verify_csrf_token();
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            error_response('Invalid JSON body', 400);
        }

        $profile_cols = [];
        try {
            $profile_cols = $db->query('SHOW COLUMNS FROM profiles')->fetchAll(PDO::FETCH_COLUMN) ?: [];
        } catch (Throwable $e) {
            $profile_cols = [];
        }

        $updates = [];
        $params = [];

        if (array_key_exists('preferred_language', $data) && in_array('preferred_language', $profile_cols, true)) {
            $lang = strtolower(trim((string)$data['preferred_language']));
            if (!in_array($lang, ['en', 'ar'], true)) {
                error_response('preferred_language must be en or ar', 400);
            }
            $updates[] = 'preferred_language = ?';
            $params[] = $lang;
        }

        if (array_key_exists('full_name', $data) && is_string($data['full_name'])) {
            $name = trim($data['full_name']);
            if ($name !== '' && mb_strlen($name) <= 120) {
                $updates[] = 'full_name = ?';
                $params[] = $name;
            }
        }

        if (empty($updates)) {
            error_response('No valid fields to update', 400);
        }

        $params[] = $user_id;
        $sql = 'UPDATE profiles SET ' . implode(', ', $updates) . ' WHERE id = ?';
        $db->prepare($sql)->execute($params);

        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        if (isset($data['preferred_language'])) {
            $_SESSION['preferred_language'] = strtolower(trim((string)$data['preferred_language']));
        }

        $out = ['updated' => true];
        if (isset($data['preferred_language'])) {
            $out['preferred_language'] = strtolower(trim((string)$data['preferred_language']));
        }
        success_response($out);
        exit;
    }

    if ($method !== 'GET') {
        error_response('Method not allowed', 405);
    }

    // ── GET ───────────────────────────────────────────────────────────────
    $profile_cols = [];
    try {
        $profile_cols = $db->query('SHOW COLUMNS FROM profiles')->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (Throwable $e) {
        $profile_cols = [];
    }

    $col = function ($name, $alias = null) use ($profile_cols) {
        $a = $alias ?: $name;
        return in_array($name, $profile_cols, true) ? "p.`{$name}` as `{$a}`" : "NULL as `{$a}`";
    };

    $selects = [
        'p.id',
        $col('username'),
        $col('full_name'),
        $col('role'),
        $col('avatar_url'),
        $col('created_at'),
        $col('preferred_language'),
        $col('academic_stage'),
        $col('class_section'),
        $col('grade_level'),
        $col('academic_year'),
        $col('class_id'),
        'cl.name as class_name',
        'g.name as grade_name',
        'ag.name as academic_group_name',
    ];

    $sql = 'SELECT ' . implode(', ', $selects) . '
        FROM profiles p
        LEFT JOIN classes cl ON p.class_id = cl.id
        LEFT JOIN grades g ON cl.grade_id = g.id
        LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id
        WHERE p.id = ?
        LIMIT 1';

    $stmt = $db->prepare($sql);
    $stmt->execute([$user_id]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$profile) {
        success_response([
            'profile' => [
                'id' => $user_id,
                'username' => $user['username'] ?? '',
                'full_name' => $user['full_name'] ?? '',
                'role' => 'student',
                'avatar_url' => $user['avatar_url'] ?? null,
                'preferred_language' => $user['preferred_language'] ?? 'en',
                'academic_group' => 'Not Assigned',
                'grade' => 'Not Assigned',
                'class' => 'Not Assigned',
                'academic_stage' => null,
                'class_section' => null,
                'grade_level' => null,
                'display_class' => null,
                'created_at' => null,
            ],
            'stats' => [
                'total_xp' => 0,
                'level' => 1,
                'current_streak' => 0,
                'completed_lessons' => 0,
                'completed_exams' => 0,
            ],
            'badges' => [],
        ]);
        exit;
    }

    $gam = [
        'total_xp' => 0,
        'current_streak' => 0,
        'longest_streak' => 0,
        'last_activity_date' => null,
    ];
    try {
        $gam_stmt = $db->prepare('SELECT total_xp, current_streak, longest_streak, last_activity_date FROM student_gamification WHERE user_id = ? LIMIT 1');
        $gam_stmt->execute([$user_id]);
        $row = $gam_stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $gam = $row;
        }
    } catch (Throwable $e) { /* table may not exist */ }

    $total_xp = (int)($gam['total_xp'] ?? 0);
    $level = (int)floor($total_xp / 100) + 1;

    $completed_lessons = 0;
    try {
        $s = $db->prepare("SELECT COUNT(*) FROM lesson_progress WHERE user_id = ? AND status = 'completed'");
        $s->execute([$user_id]);
        $completed_lessons = (int)$s->fetchColumn();
    } catch (Throwable $e) {}

    $completed_exams = 0;
    try {
        $s = $db->prepare('SELECT COUNT(*) FROM exam_attempts WHERE user_id = ? AND passed = 1');
        $s->execute([$user_id]);
        $completed_exams = (int)$s->fetchColumn();
    } catch (Throwable $e) {}

    $badges = [];
    try {
        $all_ach = $db->query('SELECT id, title, description, icon_url, xp_reward, criteria_json FROM achievements ORDER BY created_at ASC')->fetchAll(PDO::FETCH_ASSOC) ?: [];
        $earned_map = [];
        $earned_stmt = $db->prepare('SELECT achievement_id, earned_at FROM student_achievements WHERE user_id = ?');
        $earned_stmt->execute([$user_id]);
        foreach ($earned_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $earned_map[$row['achievement_id']] = $row['earned_at'];
        }
        foreach ($all_ach as $ach) {
            $is_earned = isset($earned_map[$ach['id']]);
            $badges[] = [
                'id' => $ach['id'],
                'title' => $ach['title'],
                'description' => $ach['description'],
                'icon_url' => $ach['icon_url'],
                'xp_reward' => (int)$ach['xp_reward'],
                'status' => $is_earned ? 'earned' : 'locked',
                'earned_at' => $is_earned ? $earned_map[$ach['id']] : null,
            ];
        }
    } catch (Throwable $e) {
        $badges = [];
    }

    $grade_level = $profile['grade_level'] ?? null;
    if ($grade_level === null || $grade_level === '') {
        $grade_level = $profile['academic_year'] ?? null;
    }
    $class_section = $profile['class_section'] ?? null;
    $display_class = null;
    if ($grade_level || $class_section) {
        $display_class = trim(($grade_level ?: '') . (($grade_level && $class_section) ? ' - ' : '') . ($class_section ?: ''));
    }

    $stage = $profile['academic_stage'] ?? null;
    if ($stage && stripos($stage, 'preparat') !== false) {
        $stage = 'Prep';
    }
    $group_name = $profile['academic_group_name'] ?? 'Not Assigned';
    if (is_string($group_name) && stripos($group_name, 'preparat') !== false) {
        $group_name = preg_replace('/preparatory/i', 'Prep', $group_name);
    }

    success_response([
        'profile' => [
            'id' => $profile['id'],
            'username' => $profile['username'] ?? '',
            'full_name' => $profile['full_name'] ?? '',
            'role' => $profile['role'] ?? 'student',
            'avatar_url' => $profile['avatar_url'] ?? null,
            'preferred_language' => $profile['preferred_language'] ?? 'en',
            'academic_group' => $group_name,
            'grade' => $profile['grade_name'] ?? 'Not Assigned',
            'class' => $display_class ?: ($profile['class_name'] ?? ($class_section ?? 'Not Assigned')),
            'academic_stage' => $stage,
            'class_section' => $class_section,
            'grade_level' => $grade_level,
            'academic_year' => $grade_level,
            'display_class' => $display_class,
            'created_at' => $profile['created_at'] ?? null,
        ],
        'stats' => [
            'total_xp' => $total_xp,
            'level' => $level,
            'current_streak' => (int)($gam['current_streak'] ?? 0),
            'completed_lessons' => $completed_lessons,
            'completed_exams' => $completed_exams,
        ],
        'badges' => $badges,
    ]);
} catch (Throwable $e) {
    error_log('Student Profile Error: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
    $u = $user ?? [];
    success_response([
        'profile' => [
            'id' => $u['id'] ?? null,
            'username' => $u['username'] ?? '',
            'full_name' => $u['full_name'] ?? '',
            'role' => 'student',
            'avatar_url' => $u['avatar_url'] ?? null,
            'preferred_language' => $u['preferred_language'] ?? 'en',
            'academic_group' => 'Not Assigned',
            'grade' => 'Not Assigned',
            'class' => 'Not Assigned',
            'academic_stage' => null,
            'class_section' => null,
            'grade_level' => null,
            'display_class' => null,
            'created_at' => null,
        ],
        'stats' => [
            'total_xp' => 0,
            'level' => 1,
            'current_streak' => 0,
            'completed_lessons' => 0,
            'completed_exams' => 0,
        ],
        'badges' => [],
        'warning' => 'Partial profile (server recovered from error)',
    ]);
}
