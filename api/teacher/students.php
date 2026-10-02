<?php
/**
 * Teacher roster — filter by teacher's assigned academic tier(s).
 * 4 tiers: Primary 3 & 4 | Primary 5 & 6 | Preparatory | Secondary
 * Display: grade_level + class_section (e.g. "1 Sec • Class A")
 */
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/teacher.php';

require_get_method();
$user = require_teacher();

try {
    $db = get_db_connection();
    $tid = (string) $user['id'];

    $tables = [];
    try {
        $tables = array_map('strtolower', array_map('strval', $db->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN)));
    } catch (Throwable $e) {
        $tables = [];
    }
    $has = function ($name) use ($tables) {
        return in_array(strtolower($name), $tables, true);
    };

    $profileCols = [];
    try {
        $profileCols = $db->query('SHOW COLUMNS FROM profiles')->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (Throwable $e) {
        $profileCols = [];
    }
    $hasCol = function ($c) use ($profileCols) {
        return in_array($c, $profileCols, true);
    };

    $hasTc = $has('teacher_classes');
    $hasTag = $has('teacher_academic_groups');
    $hasTsa = $has('teacher_student_assignments');
    $hasClasses = $has('classes');
    $hasGrades = $has('grades');
    $hasAg = $has('academic_groups');
    $hasGam = $has('student_gamification');
    $hasStage = $hasCol('academic_stage');
    $hasSection = $hasCol('class_section');
    $hasGradeLevel = $hasCol('grade_level') || $hasCol('academic_year');
    $gradeCol = $hasCol('grade_level') ? 'grade_level' : ($hasCol('academic_year') ? 'academic_year' : null);
    $hasActive = $hasCol('is_active');

    $assigned_classes = [];
    $assigned_levels = [];
    if ($hasTc && $hasClasses) {
        try {
            $st = $db->prepare('SELECT c.id, c.name FROM teacher_classes tc JOIN classes c ON c.id = tc.class_id WHERE tc.teacher_id = ? ORDER BY c.name');
            $st->execute([$tid]);
            $assigned_classes = $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Throwable $e) {
            $assigned_classes = [];
        }
    }
    if ($hasTag && $hasAg) {
        try {
            $st = $db->prepare('SELECT ag.id, ag.name FROM teacher_academic_groups tag JOIN academic_groups ag ON ag.id = tag.academic_group_id WHERE tag.teacher_id = ? ORDER BY ag.name');
            $st->execute([$tid]);
            $assigned_levels = $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Throwable $e) {
            $assigned_levels = [];
        }
    }
    if (!$assigned_levels && $hasTc && $hasClasses && $hasGrades && $hasAg) {
        try {
            $st = $db->prepare(
                'SELECT DISTINCT ag.id, ag.name
                 FROM teacher_classes tc
                 JOIN classes c ON c.id = tc.class_id
                 JOIN grades g ON g.id = c.grade_id
                 JOIN academic_groups ag ON ag.id = g.academic_group_id
                 WHERE tc.teacher_id = ?
                 ORDER BY ag.name'
            );
            $st->execute([$tid]);
            $assigned_levels = $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Throwable $e) {
            $assigned_levels = [];
        }
    }

    $assignmentCount = 0;
    try {
        if ($hasTc) {
            $c = $db->prepare('SELECT COUNT(*) FROM teacher_classes WHERE teacher_id = ?');
            $c->execute([$tid]);
            $assignmentCount += (int)$c->fetchColumn();
        }
        if ($hasTag) {
            $c = $db->prepare('SELECT COUNT(*) FROM teacher_academic_groups WHERE teacher_id = ?');
            $c->execute([$tid]);
            $assignmentCount += (int)$c->fetchColumn();
        }
        if ($hasTsa) {
            $c = $db->prepare('SELECT COUNT(*) FROM teacher_student_assignments WHERE teacher_id = ?');
            $c->execute([$tid]);
            $assignmentCount += (int)$c->fetchColumn();
        }
    } catch (Throwable $e) {
        $assignmentCount = 0;
    }

    $ors = [];
    $params = [];

    // 1) class_id in teacher_classes
    if ($hasTc) {
        $ors[] = 'p.class_id IN (SELECT class_id FROM teacher_classes WHERE teacher_id = ?)';
        $params[] = $tid;
    }

    // 2) class_id under teacher's academic groups
    if ($hasTag && $hasClasses && $hasGrades) {
        $ors[] = 'p.class_id IN (
            SELECT c.id FROM classes c
            JOIN grades g ON g.id = c.grade_id
            WHERE g.academic_group_id IN (SELECT academic_group_id FROM teacher_academic_groups WHERE teacher_id = ?)
        )';
        $params[] = $tid;
    }

    // 3) explicit student assignments
    if ($hasTsa) {
        $ors[] = 'p.id IN (SELECT student_id FROM teacher_student_assignments WHERE teacher_id = ?)';
        $params[] = $tid;
    }

    // 4) grade_level band match against teacher's academic group names
    //    Primary 3 & 4 → 3 Prim, 4 Prim
    //    Primary 5 & 6 → 5 Prim, 6 Prim
    //    Preparatory → *Prep*
    //    Secondary → *Sec*
    if ($gradeCol && $hasTag && $hasAg) {
        $gc = 'p.' . $gradeCol;
        $ors[] = "(
            {$gc} IS NOT NULL AND TRIM({$gc}) <> ''
            AND EXISTS (
                SELECT 1 FROM teacher_academic_groups tag
                JOIN academic_groups ag ON ag.id = tag.academic_group_id
                WHERE tag.teacher_id = ?
                  AND (
                    (
                      (LOWER(ag.name) LIKE '%primary%3%' OR LOWER(ag.name) LIKE '%primary%4%' OR LOWER(ag.name) LIKE '%3%4%')
                      AND (LOWER({$gc}) IN ('3 prim','4 prim') OR LOWER({$gc}) LIKE '3%prim%' OR LOWER({$gc}) LIKE '4%prim%')
                    )
                    OR (
                      (LOWER(ag.name) LIKE '%primary%5%' OR LOWER(ag.name) LIKE '%primary%6%' OR LOWER(ag.name) LIKE '%5%6%')
                      AND (LOWER({$gc}) IN ('5 prim','6 prim') OR LOWER({$gc}) LIKE '5%prim%' OR LOWER({$gc}) LIKE '6%prim%')
                    )
                    OR (
                      (LOWER(ag.name) LIKE '%prep%' OR LOWER(ag.name) LIKE '%prepar%')
                      AND (LOWER({$gc}) LIKE '%prep%')
                    )
                    OR (
                      LOWER(ag.name) LIKE '%second%'
                      AND (LOWER({$gc}) LIKE '%sec%')
                    )
                  )
            )
        )";
        $params[] = $tid;
    }

    // 5) stage text match (broader fallback for Prep / Secondary when grade_level empty)
    if ($hasStage && $hasTag && $hasAg) {
        $ors[] = "(
            p.academic_stage IS NOT NULL AND TRIM(p.academic_stage) <> ''
            AND EXISTS (
                SELECT 1 FROM teacher_academic_groups tag
                JOIN academic_groups ag ON ag.id = tag.academic_group_id
                WHERE tag.teacher_id = ?
                  AND (
                    (
                      (LOWER(ag.name) LIKE '%prep%' OR LOWER(ag.name) LIKE '%prepar%')
                      AND (LOWER(p.academic_stage) LIKE '%prep%' OR LOWER(p.academic_stage) LIKE '%prepar%')
                    )
                    OR (
                      LOWER(ag.name) LIKE '%second%'
                      AND LOWER(p.academic_stage) LIKE '%second%'
                    )
                    OR (
                      LOWER(ag.name) LIKE '%primary%'
                      AND LOWER(p.academic_stage) LIKE '%primary%'
                      AND (
                        -- only match primary stage students if teacher has a primary tier
                        -- grade_level filter above is preferred for 3&4 vs 5&6
                        NOT EXISTS (
                          SELECT 1 FROM profiles px WHERE px.id = p.id AND " . ($gradeCol ? "px.{$gradeCol} IS NOT NULL AND TRIM(px.{$gradeCol}) <> ''" : "1=0") . "
                        )
                      )
                    )
                  )
            )
        )";
        $params[] = $tid;
    }

    // 6) same via teacher_classes path
    if ($gradeCol && $hasTc && $hasClasses && $hasGrades && $hasAg) {
        $gc = 'p.' . $gradeCol;
        $ors[] = "(
            {$gc} IS NOT NULL AND TRIM({$gc}) <> ''
            AND EXISTS (
                SELECT 1 FROM teacher_classes tc
                JOIN classes c ON c.id = tc.class_id
                JOIN grades g ON g.id = c.grade_id
                JOIN academic_groups ag ON ag.id = g.academic_group_id
                WHERE tc.teacher_id = ?
                  AND (
                    (
                      (LOWER(ag.name) LIKE '%primary%3%' OR LOWER(ag.name) LIKE '%primary%4%' OR LOWER(ag.name) LIKE '%3%4%')
                      AND (LOWER({$gc}) IN ('3 prim','4 prim') OR LOWER({$gc}) LIKE '3%prim%' OR LOWER({$gc}) LIKE '4%prim%')
                    )
                    OR (
                      (LOWER(ag.name) LIKE '%primary%5%' OR LOWER(ag.name) LIKE '%primary%6%' OR LOWER(ag.name) LIKE '%5%6%')
                      AND (LOWER({$gc}) IN ('5 prim','6 prim') OR LOWER({$gc}) LIKE '5%prim%' OR LOWER({$gc}) LIKE '6%prim%')
                    )
                    OR (
                      (LOWER(ag.name) LIKE '%prep%' OR LOWER(ag.name) LIKE '%prepar%')
                      AND LOWER({$gc}) LIKE '%prep%'
                    )
                    OR (
                      LOWER(ag.name) LIKE '%second%'
                      AND LOWER({$gc}) LIKE '%sec%'
                    )
                  )
            )
        )";
        $params[] = $tid;
    }

    $students = [];

    if (!empty($ors) && $assignmentCount > 0) {
        $selectStage = $hasStage ? 'p.academic_stage' : 'NULL AS academic_stage';
        $selectSection = $hasSection ? 'p.class_section' : 'NULL AS class_section';
        $selectGrade = $gradeCol ? "p.{$gradeCol} AS grade_level" : 'NULL AS grade_level';
        $selectXp = $hasGam ? 'COALESCE(sg.total_xp, 0) AS total_xp' : '0 AS total_xp';
        $selectStreak = $hasGam ? 'COALESCE(sg.current_streak, 0) AS current_streak' : '0 AS current_streak';
        $selectLast = $hasGam ? 'sg.last_activity_date' : 'NULL AS last_activity_date';
        $joinGam = $hasGam ? 'LEFT JOIN student_gamification sg ON sg.user_id = p.id' : '';
        $joinClass = $hasClasses ? 'LEFT JOIN classes c ON p.class_id = c.id' : '';
        $selectClassName = $hasClasses ? 'c.name AS class_name' : 'NULL AS class_name';
        $joinGrade = ($hasClasses && $hasGrades) ? 'LEFT JOIN grades g ON c.grade_id = g.id' : '';
        $joinAg = ($hasClasses && $hasGrades && $hasAg) ? 'LEFT JOIN academic_groups ag ON g.academic_group_id = ag.id' : '';
        $selectAgId = ($hasClasses && $hasGrades && $hasAg) ? 'ag.id AS academic_group_id' : 'NULL AS academic_group_id';
        $selectAgName = ($hasClasses && $hasGrades && $hasAg) ? 'ag.name AS academic_group_name' : 'NULL AS academic_group_name';
        $selectGradeName = ($hasClasses && $hasGrades) ? 'g.name AS grade_name' : 'NULL AS grade_name';
        $activeSql = $hasActive ? 'AND COALESCE(p.is_active, 1) = 1' : '';

        $whereOr = implode("\n OR ", $ors);

        $sql = "
            SELECT DISTINCT
                p.id,
                p.username,
                p.full_name,
                p.avatar_url,
                p.created_at,
                {$selectClassName},
                {$selectAgId},
                {$selectAgName},
                {$selectGradeName},
                {$selectStage},
                {$selectSection},
                {$selectGrade},
                {$selectXp},
                {$selectStreak},
                {$selectLast},
                0 AS progress_percent
            FROM profiles p
            {$joinClass}
            {$joinGrade}
            {$joinAg}
            {$joinGam}
            WHERE p.role = 'student'
              {$activeSql}
              AND (
                {$whereOr}
              )
            ORDER BY p.full_name
            LIMIT 500
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        if ($students && $has('course_enrollments') && $has('lessons') && $has('chapters') && $has('lesson_progress')) {
            try {
                foreach ($students as &$s) {
                    $ps = $db->prepare(
                        "SELECT ROUND(AVG(
                            CASE WHEN total_lessons = 0 THEN 0
                            ELSE completed_lessons * 100.0 / total_lessons END
                        )) AS pct
                        FROM (
                            SELECT
                                (SELECT COUNT(*) FROM lessons l JOIN chapters ch ON l.chapter_id = ch.id WHERE ch.course_id = ce.course_id) AS total_lessons,
                                (SELECT COUNT(DISTINCT lp.lesson_id) FROM lesson_progress lp
                                 JOIN lessons l ON lp.lesson_id = l.id
                                 JOIN chapters ch ON l.chapter_id = ch.id
                                 WHERE lp.user_id = ce.user_id AND ch.course_id = ce.course_id AND lp.status = 'completed') AS completed_lessons
                            FROM course_enrollments ce
                            WHERE ce.user_id = ?
                        ) t"
                    );
                    $ps->execute([$s['id']]);
                    $pct = $ps->fetchColumn();
                    $s['progress_percent'] = $pct !== false && $pct !== null ? (int) $pct : 0;
                }
                unset($s);
            } catch (Throwable $e) {
            }
        }
    }

    // Normalize display fields
    foreach ($students as &$s) {
        $stage = trim((string)($s['academic_stage'] ?? ''));
        $section = trim((string)($s['class_section'] ?? ''));
        $className = trim((string)($s['class_name'] ?? ''));
        $agName = trim((string)($s['academic_group_name'] ?? ''));
        $gradeLevel = trim((string)($s['grade_level'] ?? ''));
        $gradeName = trim((string)($s['grade_name'] ?? ''));

        if ($className === '' || strcasecmp($className, 'null') === 0) {
            $s['class_name'] = $section !== '' ? $section : null;
        }
        // Prefer explicit grade_level from signup
        if ($gradeLevel === '' && $gradeName !== '') {
            $s['grade_level'] = $gradeName;
            $gradeLevel = $gradeName;
        }

        // Build human class label: "1 Sec • Class A"
        $letter = $s['class_name'] ?: ($section ?: null);
        if ($gradeLevel !== '' && $letter) {
            $s['class_label'] = $gradeLevel . ' • Class ' . $letter;
        } elseif ($gradeLevel !== '') {
            $s['class_label'] = $gradeLevel;
        } elseif ($letter) {
            $s['class_label'] = 'Class ' . $letter;
        } else {
            $s['class_label'] = null;
        }

        // Tier label from group or inferred from grade
        if ($agName === '' || strcasecmp($agName, 'null') === 0) {
            $gl = strtolower($gradeLevel);
            if (strpos($gl, '3 prim') !== false || strpos($gl, '4 prim') !== false) {
                $s['academic_group_name'] = 'Primary 3 & 4';
            } elseif (strpos($gl, '5 prim') !== false || strpos($gl, '6 prim') !== false) {
                $s['academic_group_name'] = 'Primary 5 & 6';
            } elseif (strpos($gl, 'prep') !== false || strpos(strtolower($stage), 'prep') !== false) {
                $s['academic_group_name'] = 'Preparatory';
            } elseif (strpos($gl, 'sec') !== false || strpos(strtolower($stage), 'second') !== false) {
                $s['academic_group_name'] = 'Secondary';
            } elseif (strpos(strtolower($stage), 'primary') !== false) {
                $s['academic_group_name'] = 'Primary';
            } else {
                $s['academic_group_name'] = $stage !== '' ? $stage : null;
            }
        }
    }
    unset($s);

    $notice = null;
    if ($assignmentCount === 0) {
        $notice = 'This teacher has no class/group assignments yet. In Admin → Teachers, assign a tier (Primary 3 & 4 / Primary 5 & 6 / Preparatory / Secondary).';
        $students = [];
    } elseif (count($students) === 0) {
        $notice = 'No matching students for your assigned tier(s). Students must have the matching grade (e.g. 1 Sec, 3 Prim) from registration.';
    }

    success_response([
        'students' => $students,
        'assigned_levels' => $assigned_levels,
        'assigned_classes' => $assigned_classes,
        'count' => count($students),
        'notice' => $notice,
    ]);
} catch (Throwable $e) {
    error_log('Teacher students error: ' . $e->getMessage());
    error_response('Server error loading roster: ' . $e->getMessage(), 500);
}
