<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/admin.php';
require_once __DIR__ . '/../../middleware/csrf.php';

$user = require_admin();

$method = $_SERVER['REQUEST_METHOD'];

function resolve_academic_group_id($db, $identifier) {
    $identifier = trim($identifier);
    if (empty($identifier)) return null;

    // Map Admin UI labels → the 4 canonical tiers
    $lower = strtolower($identifier);
    $canon = null;
    if (strpos($lower, 'primary') !== false && (strpos($lower, '3') !== false || strpos($lower, '4') !== false)
        && strpos($lower, '5') === false && strpos($lower, '6') === false) {
        $canon = 'Primary 3 & 4';
    } elseif (strpos($lower, 'primary') !== false && (strpos($lower, '5') !== false || strpos($lower, '6') !== false)) {
        $canon = 'Primary 5 & 6';
    } elseif (strpos($lower, 'primary') !== false) {
        $canon = 'Primary';
    } elseif (strpos($lower, 'prep') !== false || strpos($lower, 'prepar') !== false) {
        $canon = 'Preparatory';
    } elseif (strpos($lower, 'second') !== false) {
        $canon = 'Secondary';
    }
    if ($canon !== null) {
        $identifier = $canon;
    }

    // 1. Direct ID match
    $stmt = $db->prepare("SELECT id FROM academic_groups WHERE id = ?");
    $stmt->execute([$identifier]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) return $row['id'];

    // 2. Exact name match (case-insensitive)
    $stmt = $db->prepare("SELECT id FROM academic_groups WHERE LOWER(name) = LOWER(?)");
    $stmt->execute([$identifier]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) return $row['id'];

    // 3. Fuzzy match
    $stmt = $db->query("SELECT id, name FROM academic_groups");
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $normTarget = strtolower(preg_replace('/[^a-z0-9]/', '', $identifier));
    foreach ($groups as $g) {
        $normG = strtolower(preg_replace('/[^a-z0-9]/', '', $g['name']));
        if ($normG === $normTarget) {
            return $g['id'];
        }
        $gLower = strtolower($g['name']);
        if ($identifier === 'Primary 3 & 4' && strpos($gLower, 'primary') !== false && (strpos($gLower, '3') !== false || strpos($gLower, '4') !== false) && strpos($gLower, '5') === false) {
            return $g['id'];
        }
        if ($identifier === 'Primary 5 & 6' && strpos($gLower, 'primary') !== false && (strpos($gLower, '5') !== false || strpos($gLower, '6') !== false)) {
            return $g['id'];
        }
        if ($identifier === 'Preparatory' && (strpos($gLower, 'prep') !== false || strpos($gLower, 'prepar') !== false)) return $g['id'];
        if ($identifier === 'Secondary' && strpos($gLower, 'second') !== false) return $g['id'];
    }

    // 4. Create if missing
    $new_id = generate_uuid_v4();
    $insert = $db->prepare("INSERT INTO academic_groups (id, name, description) VALUES (?, ?, ?)");
    $insert->execute([$new_id, $identifier, 'Academic tier: ' . $identifier]);
    return $new_id;
}

try {
    $db = get_db_connection();

    // Check table existence safely
    $has_users_table = false;
    try {
        $u_res = $db->query("SHOW TABLES LIKE 'users'")->fetch();
        if ($u_res) $has_users_table = true;
    } catch (Exception $e) {}

    $has_teacher_classes = false;
    try {
        $tc_res = $db->query("SHOW TABLES LIKE 'teacher_classes'")->fetch();
        if ($tc_res) $has_teacher_classes = true;
    } catch (Exception $e) {}

    $p_cols = [];
    try {
        $p_desc = $db->query("DESCRIBE profiles")->fetchAll(PDO::FETCH_COLUMN);
        $p_cols = array_map('strtolower', $p_desc);
    } catch (Exception $e) {}

    if ($method === 'GET') {
        // 1. Fetch available academic groups
        $groups_stmt = $db->query("
            SELECT id, name, description,
                (SELECT COUNT(*) FROM grades g WHERE g.academic_group_id = academic_groups.id) as grades_count,
                (SELECT COUNT(*) FROM classes cl JOIN grades g ON cl.grade_id = g.id WHERE g.academic_group_id = academic_groups.id) as classes_count
            FROM academic_groups 
            ORDER BY name ASC
        ");
        $academic_groups = $groups_stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Fetch all teachers directly from users/profiles without referencing teacher_academic_groups
        $has_user_id = in_array('user_id', $p_cols);
        $email_select = ($has_users_table) ? 'u.email as email' : (in_array('email', $p_cols) ? 'p.email as email' : "'' as email");
        $user_join = ($has_users_table) ? ($has_user_id ? "LEFT JOIN users u ON u.id = p.user_id" : "LEFT JOIN users u ON u.id = p.id") : "";
        $username_select = in_array('username', $p_cols) ? 'p.username' : ($has_users_table ? "COALESCE(u.username, '') as username" : "'' as username");

        $students_subquery = $has_teacher_classes ? "
            (
                SELECT COUNT(DISTINCT stu.id)
                FROM profiles stu
                JOIN classes c ON stu.class_id = c.id
                JOIN teacher_classes tc ON tc.class_id = c.id
                WHERE stu.role = 'student' AND tc.teacher_id = p.id
            ) as students_count
        " : "0 as students_count";

        $graded_subquery = $has_teacher_classes ? "
            (
                SELECT COUNT(*)
                FROM project_submissions ps
                JOIN profiles stu ON ps.user_id = stu.id
                JOIN classes c ON stu.class_id = c.id
                JOIN teacher_classes tc ON tc.class_id = c.id
                WHERE ps.status = 'graded' AND tc.teacher_id = p.id
            ) as graded_submissions_count
        " : "0 as graded_submissions_count";

        $teachers_query = "
            SELECT 
                p.id, {$username_select}, p.full_name, {$email_select}, p.avatar_url, p.created_at,
                {$students_subquery},
                {$graded_subquery},
                (
                    SELECT COUNT(*)
                    FROM assignments a
                    WHERE a.teacher_id = p.id
                ) as assignments_count
            FROM profiles p
            {$user_join}
            WHERE p.role = 'teacher' OR " . ($has_users_table ? "u.role = 'teacher'" : "1=0") . "
            ORDER BY p.full_name ASC
        ";

        $teachers_stmt = $db->query($teachers_query);
        $teachers = $teachers_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Map assigned levels: prefer teacher_academic_groups, fall back to teacher_classes path
        $has_tag = false;
        try {
            $has_tag = (bool) $db->query("SHOW TABLES LIKE 'teacher_academic_groups'")->fetch();
        } catch (Exception $e) {}

        foreach ($teachers as &$t) {
            $t['academic_levels'] = [];
            if ($has_tag) {
                try {
                    $levels_stmt = $db->prepare("
                        SELECT DISTINCT ag.id, ag.name
                        FROM teacher_academic_groups tag
                        JOIN academic_groups ag ON ag.id = tag.academic_group_id
                        WHERE tag.teacher_id = ?
                        ORDER BY ag.name ASC
                    ");
                    $levels_stmt->execute([$t['id']]);
                    $t['academic_levels'] = $levels_stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
                } catch (Exception $e) {
                    $t['academic_levels'] = [];
                }
            }
            if (empty($t['academic_levels']) && $has_teacher_classes) {
                $levels_stmt = $db->prepare("
                    SELECT DISTINCT ag.id, ag.name 
                    FROM teacher_classes tc
                    JOIN classes c ON tc.class_id = c.id
                    JOIN grades g ON c.grade_id = g.id
                    JOIN academic_groups ag ON g.academic_group_id = ag.id
                    WHERE tc.teacher_id = ?
                    ORDER BY ag.name ASC
                ");
                $levels_stmt->execute([$t['id']]);
                $t['academic_levels'] = $levels_stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
            }
        }
        unset($t);

        success_response([
            'teachers' => $teachers,
            'academic_groups' => $academic_groups
        ]);
    } 
    elseif ($method === 'POST') {
        verify_csrf_token();
        $data = get_json_request();
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $action = trim($data['action'] ?? 'create');

        if ($action === 'create') {
            $username = trim($data['username'] ?? '');
            $full_name = trim($data['full_name'] ?? '');
            $password = $data['password'] ?? '';
            $raw_academic_levels = $data['academic_group_ids'] ?? [];

            if (!is_array($raw_academic_levels)) {
                $raw_academic_levels = $raw_academic_levels ? [$raw_academic_levels] : [];
            }

            if (empty($username) || empty($full_name) || empty($password)) {
                error_response('Full Name, Username, and Temporary Password are required', 400);
            }

            if (strlen($username) < 3 || strlen($username) > 50) {
                error_response('Username must be between 3 and 50 characters', 400);
            }

            if (strlen($password) < 6) {
                error_response('Password must be at least 6 characters', 400);
            }

            // Check if username already exists
            $check_stmt = $db->prepare("SELECT id FROM profiles WHERE LOWER(username) = LOWER(?)");
            $check_stmt->execute([$username]);
            if ($check_stmt->fetch()) {
                error_response('Username is already taken', 409);
            }

            $teacher_id = generate_uuid_v4();
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $avatar_url = 'https://ui-avatars.com/api/?name=' . urlencode($full_name) . '&background=3B82F6&color=FFFFFF';

            $db->beginTransaction();

            $insert_stmt = $db->prepare("
                INSERT INTO profiles (id, username, password_hash, full_name, role, is_active, avatar_url, created_at, updated_at)
                VALUES (?, ?, ?, ?, 'teacher', 1, ?, NOW(), NOW())
            ");
            $insert_stmt->execute([$teacher_id, $username, $password_hash, $full_name, $avatar_url]);

            // Assign classes in teacher_classes if teacher_classes table exists
            if ($has_teacher_classes) {
                $assigned_group_ids = [];
                foreach ($raw_academic_levels as $raw_lvl) {
                    $resolved_id = resolve_academic_group_id($db, $raw_lvl);
                    if (!$resolved_id || in_array($resolved_id, $assigned_group_ids)) continue;
                    $assigned_group_ids[] = $resolved_id;

                    // Also record academic group assignment for roster stage-matching
                    try {
                        $tagId = bin2hex(random_bytes(16));
                        $tagId = sprintf('%s-%s-%s-%s-%s',
                            substr($tagId,0,8), substr($tagId,8,4), substr($tagId,12,4),
                            substr($tagId,16,4), substr($tagId,20,12));
                        if (function_exists('generate_uuid_v4')) { $tagId = generate_uuid_v4(); }
                        $db->prepare("INSERT IGNORE INTO teacher_academic_groups (id, teacher_id, academic_group_id) VALUES (?, ?, ?)")
                           ->execute([$tagId, $teacher_id, $resolved_id]);
                    } catch (Throwable $tagEx) {
                        error_log('teacher_academic_groups insert: ' . $tagEx->getMessage());
                    }

                    $classes_stmt = $db->prepare("
                        SELECT cl.id 
                        FROM classes cl
                        JOIN grades g ON cl.grade_id = g.id
                        WHERE g.academic_group_id = ?
                    ");
                    $classes_stmt->execute([$resolved_id]);
                    $classes = $classes_stmt->fetchAll(PDO::FETCH_COLUMN);

                    foreach ($classes as $class_id) {
                        $tc_id = generate_uuid_v4();
                        $tc_stmt = $db->prepare("
                            INSERT IGNORE INTO teacher_classes (id, teacher_id, class_id)
                            VALUES (?, ?, ?)
                        ");
                        $tc_stmt->execute([$tc_id, $teacher_id, $class_id]);
                    }
                }
            }

            $db->commit();

            success_response([
                'message' => 'Teacher account created successfully',
                'teacher_id' => $teacher_id
            ], 201);
        }
        elseif ($action === 'update_levels') {
            $teacher_id = trim($data['teacher_id'] ?? '');
            $raw_academic_levels = $data['academic_group_ids'] ?? [];
            if (!is_array($raw_academic_levels)) {
                $raw_academic_levels = $raw_academic_levels ? [$raw_academic_levels] : [];
            }

            if (empty($teacher_id)) {
                error_response('Teacher ID is required', 400);
            }

            // Verify teacher exists
            $t_stmt = $db->prepare("SELECT id FROM profiles WHERE id = ? AND role = 'teacher'");
            $t_stmt->execute([$teacher_id]);
            if (!$t_stmt->fetch()) {
                error_response('Teacher not found', 404);
            }

            $db->beginTransaction();

            if ($has_teacher_classes) {
                $db->prepare("DELETE FROM teacher_classes WHERE teacher_id = ?")->execute([$teacher_id]);
            }
            // Keep teacher_academic_groups in sync (required for stage-based roster filtering)
            try {
                $db->query("SHOW TABLES LIKE 'teacher_academic_groups'")->fetch();
                $db->prepare("DELETE FROM teacher_academic_groups WHERE teacher_id = ?")->execute([$teacher_id]);
            } catch (Throwable $e) { /* table may not exist */ }

            $assigned_group_ids = [];
            foreach ($raw_academic_levels as $raw_lvl) {
                $resolved_id = resolve_academic_group_id($db, $raw_lvl);
                if (!$resolved_id || in_array($resolved_id, $assigned_group_ids)) continue;
                $assigned_group_ids[] = $resolved_id;

                try {
                    $tagId = generate_uuid_v4();
                    $db->prepare("INSERT IGNORE INTO teacher_academic_groups (id, teacher_id, academic_group_id) VALUES (?, ?, ?)")
                       ->execute([$tagId, $teacher_id, $resolved_id]);
                } catch (Throwable $tagEx) {
                    error_log('teacher_academic_groups update: ' . $tagEx->getMessage());
                }

                if ($has_teacher_classes) {
                    $classes_stmt = $db->prepare("
                        SELECT cl.id 
                        FROM classes cl
                        JOIN grades g ON cl.grade_id = g.id
                        WHERE g.academic_group_id = ?
                    ");
                    $classes_stmt->execute([$resolved_id]);
                    $classes = $classes_stmt->fetchAll(PDO::FETCH_COLUMN);

                    foreach ($classes as $class_id) {
                        $tc_id = generate_uuid_v4();
                        $db->prepare("INSERT IGNORE INTO teacher_classes (id, teacher_id, class_id) VALUES (?, ?, ?)")
                           ->execute([$tc_id, $teacher_id, $class_id]);
                    }
                }
            }

            $db->commit();
            success_response(['message' => 'Academic level assignments updated successfully']);
        }
        elseif ($action === 'delete') {
            $teacher_id = trim($data['teacher_id'] ?? '');
            if (empty($teacher_id)) {
                error_response('Teacher ID is required', 400);
            }

            $t_stmt = $db->prepare("SELECT id, username FROM profiles WHERE id = ? AND role = 'teacher'");
            $t_stmt->execute([$teacher_id]);
            $teacher = $t_stmt->fetch(PDO::FETCH_ASSOC);
            if (!$teacher) {
                error_response('Teacher not found', 404);
            }

            $db->prepare("DELETE FROM profiles WHERE id = ?")->execute([$teacher_id]);
            success_response(['message' => "Teacher account '{$teacher['username']}' deleted successfully"]);
        }
        else {
            error_response('Invalid action', 400);
        }
    } 
    else {
        error_response('Method not allowed', 405);
    }
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    error_log('Admin Teachers API Error: ' . $e->getMessage());
    error_response('Teacher management error. Please try again.', 500);
}
