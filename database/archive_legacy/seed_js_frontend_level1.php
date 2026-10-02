<?php
/**
 * LEGACY / OPTIONAL — NOT required for normal production install.
 * FE Level 1 and JS Level 1 are included in database/seed_curriculum.php.
 * Keep only for historical recovery from content_sources/*.md.
 *
 * SPS Code Orbit — Seed JavaScript Level 1 + Frontend Level 1
 * Sources: content_sources/javascript_level_1_*.md, frontend_level_1_*.md
 * Curriculum JS: data/javascript_level1_curriculum.js, data/frontend_level1_curriculum.js
 *
 * Idempotent: checks for existing course IDs and reconciles instead of duplicating.
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

function load_curriculum_js($path, $varName) {
    if (!file_exists($path)) {
        throw new Exception("Missing curriculum file: $path");
    }
    $raw = file_get_contents($path);
    $needle = 'const ' . $varName . ' = {';
    $pos = strpos($raw, $needle);
    if ($pos === false) {
        $needle = 'const ' . $varName . '={';
        $pos = strpos($raw, $needle);
    }
    if ($pos === false) {
        throw new Exception("Could not find $varName in $path");
    }
    $start = strpos($raw, '{', $pos);
    $depth = 0;
    $inStr = null;
    $esc = false;
    $len = strlen($raw);
    for ($i = $start; $i < $len; $i++) {
        $ch = $raw[$i];
        if ($inStr !== null) {
            if ($esc) { $esc = false; continue; }
            if ($ch === '\\') { $esc = true; continue; }
            if ($ch === $inStr) { $inStr = null; }
            continue;
        }
        if ($ch === '"' || $ch === "'" || $ch === '`') { $inStr = $ch; continue; }
        if ($ch === '{') { $depth++; continue; }
        if ($ch === '}') {
            $depth--;
            if ($depth === 0) {
                $json = substr($raw, $start, $i - $start + 1);
                $data = json_decode($json, true);
                if (!$data) {
                    throw new Exception("JSON decode failed for $varName: " . json_last_error_msg());
                }
                return $data;
            }
        }
    }
    throw new Exception("Unbalanced braces for $varName in $path");
}

function uuid() {
    return generate_uuid_v4();
}

try {
    $db = get_db_connection();
    $db->beginTransaction();

    // Academic group
    $stmt = $db->prepare("SELECT id FROM academic_groups WHERE name = ? OR name = ? LIMIT 1");
    $stmt->execute(['Prep', 'Foundation Track']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $ag_id = $row['id'];
    } else {
        $ag_id = uuid();
        $db->prepare("INSERT INTO academic_groups (id, name, description) VALUES (?, ?, ?)")
           ->execute([$ag_id, 'Prep', 'Interactive coding and web adventures']);
    }

    $courses = [
        [
            'js_file' => __DIR__ . '/../data/javascript_level1_curriculum.js',
            'var' => 'JAVASCRIPT_LEVEL1_COURSE',
            'ar_title' => 'JavaScript — المستوى الأول',
            'ar_desc' => 'تعلّم اللبنات الأساسية للغة JavaScript — المتغيرات، وأنواع البيانات، والعوامل، والقرارات، والدوال، والمصفوفات، والكائنات، والحلقات.',
        ],
        [
            'js_file' => __DIR__ . '/../data/frontend_level1_curriculum.js',
            'var' => 'FRONTEND_LEVEL1_COURSE',
            'ar_title' => 'Frontend — المستوى الأول',
            'ar_desc' => 'تعلّم إنشاء هيكل ومظهر صفحات الويب باستخدام HTML وCSS من الصفر.',
        ],
    ];

    foreach ($courses as $meta) {
        $course = load_curriculum_js($meta['js_file'], $meta['var']);
        $cid = $course['id'];

        // Upsert course
        $stmt = $db->prepare("SELECT id FROM courses WHERE id = ? OR slug = ? LIMIT 1");
        $stmt->execute([$cid, $course['slug']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $cid = $existing['id'];
            $db->prepare("UPDATE courses SET title=?, description=?, image_url=?, accent_color=?, is_published=1, academic_group_id=? WHERE id=?")
               ->execute([$course['title'], $course['description'], $course['image_url'], $course['accent_color'], $ag_id, $cid]);
            echo "Updated course: {$course['title']}\n";
        } else {
            $db->prepare("INSERT INTO courses (id, academic_group_id, slug, title, description, image_url, accent_color, is_published) VALUES (?,?,?,?,?,?,?,1)")
               ->execute([$cid, $ag_id, $course['slug'], $course['title'], $course['description'], $course['image_url'], $course['accent_color']]);
            echo "Inserted course: {$course['title']}\n";
        }

        // Translations EN + AR
        foreach ([['en', $course['title'], $course['description']], ['ar', $meta['ar_title'], $meta['ar_desc']]] as $tr) {
            [$lang, $title, $desc] = $tr;
            $stmt = $db->prepare("SELECT id FROM course_translations WHERE course_id=? AND language=?");
            $stmt->execute([$cid, $lang]);
            if ($stmt->fetch()) {
                $db->prepare("UPDATE course_translations SET title=?, description=? WHERE course_id=? AND language=?")
                   ->execute([$title, $desc, $cid, $lang]);
            } else {
                $db->prepare("INSERT INTO course_translations (id, course_id, language, title, description) VALUES (?,?,?,?,?)")
                   ->execute([uuid(), $cid, $lang, $title, $desc]);
            }
        }

        foreach ($course['chapters'] as $ch) {
            $chid = $ch['id'];
            $stmt = $db->prepare("SELECT id FROM chapters WHERE id=? OR (course_id=? AND slug=?) LIMIT 1");
            $stmt->execute([$chid, $cid, $ch['slug']]);
            $ex = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ex) {
                $chid = $ex['id'];
                $db->prepare("UPDATE chapters SET title=?, description=?, chapter_number=?, icon_symbol=? WHERE id=?")
                   ->execute([$ch['title'], $ch['description'] ?? '', $ch['chapter_number'], $ch['icon_symbol'] ?? '📘', $chid]);
            } else {
                $db->prepare("INSERT INTO chapters (id, course_id, slug, chapter_number, title, description, icon_symbol) VALUES (?,?,?,?,?,?,?)")
                   ->execute([$chid, $cid, $ch['slug'], $ch['chapter_number'], $ch['title'], $ch['description'] ?? '', $ch['icon_symbol'] ?? '📘']);
            }

            // Chapter translations (EN uses source title; AR mirror for now from EN structure — full AR content in content_sources)
            foreach ([['en', $ch['title'], $ch['description'] ?? ''], ['ar', $ch['title'], $ch['description'] ?? '']] as $tr) {
                [$lang, $title, $desc] = $tr;
                $stmt = $db->prepare("SELECT id FROM chapter_translations WHERE chapter_id=? AND language=?");
                $stmt->execute([$chid, $lang]);
                if ($stmt->fetch()) {
                    $db->prepare("UPDATE chapter_translations SET title=?, description=? WHERE chapter_id=? AND language=?")
                       ->execute([$title, $desc, $chid, $lang]);
                } else {
                    $db->prepare("INSERT INTO chapter_translations (id, chapter_id, language, title, description) VALUES (?,?,?,?,?)")
                       ->execute([uuid(), $chid, $lang, $title, $desc]);
                }
            }

            foreach ($ch['lessons'] as $les) {
                $lid = $les['id'];
                $stmt = $db->prepare("SELECT id FROM lessons WHERE id=? OR (chapter_id=? AND slug=?) LIMIT 1");
                $stmt->execute([$lid, $chid, $les['slug']]);
                $ex = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($ex) {
                    $lid = $ex['id'];
                    $db->prepare("UPDATE lessons SET title=?, lesson_number=?, duration_minutes=?, xp_reward=? WHERE id=?")
                       ->execute([$les['title'], $les['lesson_number'], $les['duration'] ?? 12, $les['xp_reward'] ?? 25, $lid]);
                } else {
                    $db->prepare("INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward) VALUES (?,?,?,?,?,?,?)")
                       ->execute([$lid, $chid, $les['slug'], $les['lesson_number'], $les['title'], $les['duration'] ?? 12, $les['xp_reward'] ?? 25]);
                }

                // Lesson translation EN
                $stmt = $db->prepare("SELECT id FROM lesson_translations WHERE lesson_id=? AND language='en'");
                $stmt->execute([$lid]);
                if ($stmt->fetch()) {
                    $db->prepare("UPDATE lesson_translations SET title=? WHERE lesson_id=? AND language='en'")
                       ->execute([$les['title'], $lid]);
                } else {
                    // table may have more columns — insert minimal
                    try {
                        $db->prepare("INSERT INTO lesson_translations (id, lesson_id, language, title) VALUES (?,?, 'en', ?)")
                           ->execute([uuid(), $lid, $les['title']]);
                    } catch (Exception $e) {
                        // schema variance — ignore non-critical
                    }
                }

                // Replace lesson blocks
                $db->prepare("DELETE FROM lesson_blocks WHERE lesson_id=?")->execute([$lid]);
                $order = 0;
                foreach ($les['blocks'] as $block) {
                    $order++;
                    $db->prepare("INSERT INTO lesson_blocks (id, lesson_id, block_type, order_index, content_json) VALUES (?,?,?,?,?)")
                       ->execute([uuid(), $lid, $block['block_type'], $order, json_encode($block['content'], JSON_UNESCAPED_UNICODE)]);
                }
            }
        }
        echo "  Chapters: " . count($course['chapters']) . ", Lessons: " . $course['lessonsCount'] . "\n";
    }

    $db->commit();
    echo "Seed complete (JS Level 1 + Frontend Level 1).\n";
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
