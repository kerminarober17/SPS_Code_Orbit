<?php
/**
 * SPS Code Orbit — OFFICIAL production curriculum seed
 *
 * ONLY recommended path for loading courses/chapters/lessons into MySQL
 * after importing database/MASTER_DATABASE.sql.
 *
 * Source of structure: data/curriculum_export.json
 * Rich lesson bodies remain in data/*_curriculum.js (rendered by the student UI).
 * MySQL stores course/chapter/lesson rows for enrollment, progress, and exams.
 *
 * Official production courses (all five, is_published = 1):
 *   course-programming-foundations  — 6 chapters / 24 lessons
 *   course-python-foundations       — 10 chapters / 40 lessons
 *   course-python-level-2           — 10 chapters / 40 lessons
 *   course-javascript-level-1       — 6 chapters / 28 lessons
 *   course-frontend-level-1         — 5 chapters / 23 lessons
 * Total: 37 chapters / 155 lessons
 *
 * Usage (CLI on server):
 *   php database/seed_curriculum.php
 *
 * Do NOT use production_rebuild.sql or seed_js_frontend_* for normal installs.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

/** Expected chapter/lesson counts — fail loud if export disagrees. */
const SPS_EXPECTED_COURSE_COUNTS = [
    'course-programming-foundations' => ['chapters' => 6,  'lessons' => 24, 'title' => 'Programming Foundations'],
    'course-python-foundations'      => ['chapters' => 10, 'lessons' => 40, 'title' => 'Python Foundations'],
    'course-python-level-2'          => ['chapters' => 10, 'lessons' => 40, 'title' => 'Python Level 2'],
    'course-javascript-level-1'      => ['chapters' => 6,  'lessons' => 28, 'title' => 'JavaScript Level 1'],
    'course-frontend-level-1'        => ['chapters' => 5,  'lessons' => 23, 'title' => 'Frontend Level 1'],
];

const SPS_EXPECTED_TOTAL_CHAPTERS = 37;
const SPS_EXPECTED_TOTAL_LESSONS  = 155;

try {
    $db = get_db_connection();
    echo "=== SPS Code Orbit — Official curriculum seed ===\n";
    echo "Source: data/curriculum_export.json\n";
    echo "Target: MySQL courses / chapters / lessons (is_published=1)\n\n";

    // 1. Academic groups
    $groups = [
        ['name' => 'Preparatory', 'desc' => 'Interactive coding and web adventures for preparatory students'],
        ['name' => 'Primary 3 & 4', 'desc' => 'Visual programming logic'],
        ['name' => 'Primary 5 & 6', 'desc' => 'Creative coding'],
        ['name' => 'Secondary', 'desc' => 'Advanced computer science'],
    ];

    $ag_map = [];
    foreach ($groups as $g) {
        $alt_name = str_replace(' & ', '-', $g['name']);
        $stmt = $db->prepare('SELECT id FROM academic_groups WHERE name = ? OR name = ? LIMIT 1');
        $stmt->execute([$g['name'], $alt_name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $ag_map[$g['name']] = $row['id'];
            $ag_map[$alt_name] = $row['id'];
        } else {
            $id = generate_uuid_v4();
            $ins = $db->prepare('INSERT INTO academic_groups (id, name, description) VALUES (?, ?, ?)');
            $ins->execute([$id, $g['name'], $g['desc']]);
            $ag_map[$g['name']] = $id;
            $ag_map[$alt_name] = $id;
        }
    }

    // 2. Load export
    $json_file = __DIR__ . '/../data/curriculum_export.json';
    if (!file_exists($json_file)) {
        throw new Exception("Curriculum export file missing: {$json_file}");
    }

    $curriculum = json_decode(file_get_contents($json_file), true);
    if (!is_array($curriculum) || $curriculum === []) {
        throw new Exception('curriculum_export.json is empty or invalid JSON');
    }

    $allowed_course_ids = array_keys(SPS_EXPECTED_COURSE_COUNTS);

    // Index export by id
    $by_id = [];
    foreach ($curriculum as $c_def) {
        if (!is_array($c_def) || empty($c_def['id'])) {
            continue;
        }
        $by_id[$c_def['id']] = $c_def;
    }

    // 3. Validate ALL five official courses exist with expected counts BEFORE writing
    $validation_errors = [];
    $report = [];
    $total_chapters = 0;
    $total_lessons = 0;

    foreach ($allowed_course_ids as $cid) {
        $exp = SPS_EXPECTED_COURSE_COUNTS[$cid];
        if (!isset($by_id[$cid])) {
            $validation_errors[] = "MISSING course in export: {$cid} ({$exp['title']})";
            continue;
        }
        $c_def = $by_id[$cid];
        $chapters = $c_def['chapters'] ?? [];
        if (!is_array($chapters)) {
            $validation_errors[] = "{$cid}: chapters is not an array";
            continue;
        }
        $ch_count = count($chapters);
        $les_count = 0;
        $seen_ch = [];
        $seen_les = [];
        foreach ($chapters as $ch) {
            $chid = $ch['id'] ?? '';
            if ($chid === '' || isset($seen_ch[$chid])) {
                $validation_errors[] = "{$cid}: invalid or duplicate chapter id " . ($chid ?: '(empty)');
            }
            $seen_ch[$chid] = true;
            $lessons = $ch['lessons'] ?? [];
            if (!is_array($lessons) || count($lessons) === 0) {
                $validation_errors[] = "{$cid} / {$chid}: chapter has zero lessons";
            }
            foreach ($lessons as $les) {
                $lid = $les['id'] ?? '';
                if ($lid === '' || isset($seen_les[$lid])) {
                    $validation_errors[] = "{$cid}: invalid or duplicate lesson id " . ($lid ?: '(empty)');
                }
                $seen_les[$lid] = true;
                $les_count++;
            }
        }
        if ($ch_count !== $exp['chapters'] || $les_count !== $exp['lessons']) {
            $validation_errors[] = sprintf(
                '%s (%s): expected %d chapters / %d lessons, found %d / %d',
                $cid,
                $exp['title'],
                $exp['chapters'],
                $exp['lessons'],
                $ch_count,
                $les_count
            );
        }
        $report[$cid] = [
            'title' => $c_def['title'] ?? $exp['title'],
            'chapters' => $ch_count,
            'lessons' => $les_count,
        ];
        $total_chapters += $ch_count;
        $total_lessons += $les_count;
    }

    $found_official = count(array_intersect(array_keys($by_id), $allowed_course_ids));
    if ($found_official !== 5) {
        $validation_errors[] = "Expected 5 official courses in export, found {$found_official}";
    }
    if ($total_chapters !== SPS_EXPECTED_TOTAL_CHAPTERS || $total_lessons !== SPS_EXPECTED_TOTAL_LESSONS) {
        $validation_errors[] = sprintf(
            'Expected totals %d chapters / %d lessons, computed %d / %d',
            SPS_EXPECTED_TOTAL_CHAPTERS,
            SPS_EXPECTED_TOTAL_LESSONS,
            $total_chapters,
            $total_lessons
        );
    }

    if ($validation_errors) {
        echo "VALIDATION FAILED — refusing to seed partial curriculum:\n";
        foreach ($validation_errors as $err) {
            echo "  - {$err}\n";
        }
        throw new Exception('Curriculum export validation failed. Fix data/curriculum_export.json and retry.');
    }

    echo "Courses found in export: " . count($by_id) . "\n";
    echo "Official courses to seed: 5\n";
    foreach ($report as $cid => $r) {
        echo "  {$r['title']}: {$r['chapters']} chapters / {$r['lessons']} lessons\n";
    }
    echo "Total: {$total_chapters} chapters / {$total_lessons} lessons\n\n";

    // 4. Upsert
    $courses_seeded = 0;
    foreach ($allowed_course_ids as $cid) {
        $c_def = $by_id[$cid];

        $ag_name = $c_def['academic_group'] ?? $c_def['academic_group_name'] ?? 'Preparatory';
        $ag_id = $ag_map[$ag_name] ?? array_values($ag_map)[0];

        // Prefer real files under /assets/courses (named after the course track)
        $courseImageMap = [
            'course-programming-foundations' => '/assets/courses/programming_foundations.jpeg',
            'course-python-foundations'      => '/assets/courses/Py_L1.jpeg',
            'course-python-level-2'          => '/assets/courses/Py_L2.jpeg',
            'course-javascript-level-1'      => '/assets/courses/js_L1.jpeg',
            'course-frontend-level-1'        => '/assets/courses/frontend_L1.jpeg',
        ];
        if (!empty($courseImageMap[$c_def['id']])) {
            $c_def['image_url'] = $courseImageMap[$c_def['id']];
            $c_def['image'] = $courseImageMap[$c_def['id']];
        }

        $stmt_course = $db->prepare("
            INSERT INTO courses (id, academic_group_id, title, slug, description, image_url, accent_color, is_published, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                academic_group_id = VALUES(academic_group_id),
                title = VALUES(title),
                slug = VALUES(slug),
                description = VALUES(description),
                image_url = VALUES(image_url),
                accent_color = VALUES(accent_color),
                is_published = 1,
                updated_at = NOW()
        ");
        $stmt_course->execute([
            $c_def['id'],
            $ag_id,
            $c_def['title'],
            $c_def['slug'],
            $c_def['description'] ?? '',
            $c_def['image_url'] ?? null,
            $c_def['accent_color'] ?? null,
        ]);
        $courses_seeded++;
        echo "Synced course: {$c_def['title']}\n";

        foreach (($c_def['chapters'] ?? []) as $ch_idx => $ch_def) {
            $ch_number = $ch_def['chapter_number'] ?? $ch_def['number'] ?? ($ch_idx + 1);
            $stmt_ch = $db->prepare("
                INSERT INTO chapters (id, course_id, slug, chapter_number, title, description, icon_symbol, xp_reward, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, 100, NOW(), NOW())
                ON DUPLICATE KEY UPDATE
                    course_id = VALUES(course_id),
                    slug = VALUES(slug),
                    chapter_number = VALUES(chapter_number),
                    title = VALUES(title),
                    description = VALUES(description),
                    icon_symbol = VALUES(icon_symbol),
                    updated_at = NOW()
            ");
            $stmt_ch->execute([
                $ch_def['id'],
                $c_def['id'],
                $ch_def['slug'] ?? $ch_def['id'],
                $ch_number,
                $ch_def['title'],
                $ch_def['description'] ?? '',
                $ch_def['icon_symbol'] ?? '🚀',
            ]);

            foreach (($ch_def['lessons'] ?? []) as $l_idx => $l_def) {
                $l_number = $l_def['lesson_number'] ?? $l_def['number'] ?? ($l_idx + 1);
                $stmt_l = $db->prepare("
                    INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                        chapter_id = VALUES(chapter_id),
                        slug = VALUES(slug),
                        lesson_number = VALUES(lesson_number),
                        title = VALUES(title),
                        duration_minutes = VALUES(duration_minutes),
                        xp_reward = VALUES(xp_reward),
                        updated_at = NOW()
                ");
                $stmt_l->execute([
                    $l_def['id'],
                    $ch_def['id'],
                    $l_def['slug'] ?? $l_def['id'],
                    $l_number,
                    $l_def['title'],
                    $l_def['duration'] ?? $l_def['duration_minutes'] ?? 12,
                    $l_def['xp_reward'] ?? $l_def['xp'] ?? 25,
                ]);

                if (!empty($l_def['blocks']) && is_array($l_def['blocks'])) {
                    $chk_blocks = $db->prepare('SELECT COUNT(*) FROM lesson_blocks WHERE lesson_id = ?');
                    $chk_blocks->execute([$l_def['id']]);
                    if ((int) $chk_blocks->fetchColumn() === 0) {
                        $order = 1;
                        $stmt_insert_block = $db->prepare(
                            'INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES (?, ?, ?, ?, ?)'
                        );
                        foreach ($l_def['blocks'] as $b) {
                            $b_id = generate_uuid_v4();
                            $b_type = $b['block_type'] ?? 'text';
                            $b_content = $b['content'] ?? $b['content_json'] ?? $b;
                            $stmt_insert_block->execute([$b_id, $l_def['id'], $b_type, $order++, json_encode($b_content)]);
                        }
                    }
                }
            }
        }
    }

    // 5. Post-seed DB verification
    echo "\n--- Post-seed verification ---\n";
    $db_errors = [];
    foreach ($allowed_course_ids as $cid) {
        $exp = SPS_EXPECTED_COURSE_COUNTS[$cid];
        $row = $db->prepare('SELECT id, is_published, title FROM courses WHERE id = ? LIMIT 1');
        $row->execute([$cid]);
        $course = $row->fetch(PDO::FETCH_ASSOC);
        if (!$course) {
            $db_errors[] = "DB missing course row: {$cid}";
            continue;
        }
        if ((int) $course['is_published'] !== 1) {
            $db_errors[] = "DB course not published: {$cid}";
        }
        $ch_n = (int) $db->query('SELECT COUNT(*) FROM chapters WHERE course_id = ' . $db->quote($cid))->fetchColumn();
        $les_n = (int) $db->query(
            'SELECT COUNT(*) FROM lessons l JOIN chapters ch ON l.chapter_id = ch.id WHERE ch.course_id = ' . $db->quote($cid)
        )->fetchColumn();
        echo "  {$course['title']}: {$ch_n} chapters / {$les_n} lessons (published=" . (int) $course['is_published'] . ")\n";
        if ($ch_n !== $exp['chapters'] || $les_n !== $exp['lessons']) {
            $db_errors[] = "{$cid}: DB has {$ch_n}/{$les_n}, expected {$exp['chapters']}/{$exp['lessons']}";
        }
    }

    if ($db_errors) {
        echo "POST-SEED VERIFICATION FAILED:\n";
        foreach ($db_errors as $err) {
            echo "  - {$err}\n";
        }
        throw new Exception('Database curriculum counts do not match expected production set.');
    }

    echo "\nCourses seeded: {$courses_seeded}\n";
    echo "Curriculum sync completed successfully.\n";
    echo "Next step: php database/seed_exams.php\n";
} catch (Exception $e) {
    echo 'Error during curriculum synchronization: ' . $e->getMessage() . "\n";
    if (PHP_SAPI === 'cli') {
        exit(1);
    }
}
