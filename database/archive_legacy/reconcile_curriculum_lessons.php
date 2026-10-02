<?php
/**
 * SPS Code Orbit — Reconcile curriculum_export.json lessons into MySQL
 *
 * Safe / idempotent:
 * - Upserts courses, chapters, lessons from data/curriculum_export.json
 * - Does NOT delete student progress, enrollments, or other courses
 * - Does NOT wipe lesson_blocks content (only ensures lesson metadata rows exist)
 *
 * Run from project root on the server:
 *   php database/reconcile_curriculum_lessons.php
 *
 * Focus courses (all courses in export are reconciled):
 *   - course-python-level-2
 *   - course-javascript-level-1
 *   - course-frontend-level-1
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

$json_file = __DIR__ . '/../data/curriculum_export.json';
if (!file_exists($json_file)) {
    fwrite(STDERR, "Missing data/curriculum_export.json\n");
    exit(1);
}

$curriculum = json_decode(file_get_contents($json_file), true);
if (!is_array($curriculum)) {
    fwrite(STDERR, "Invalid curriculum_export.json\n");
    exit(1);
}

try {
    $db = get_db_connection();
    $ag_id = $db->query("SELECT id FROM academic_groups ORDER BY name LIMIT 1")->fetchColumn() ?: null;

    $stmt_course = $db->prepare("
        INSERT INTO courses (id, academic_group_id, title, slug, description, image_url, accent_color, is_published, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
        ON DUPLICATE KEY UPDATE title=VALUES(title), slug=VALUES(slug), description=VALUES(description),
            image_url=VALUES(image_url), accent_color=VALUES(accent_color), is_published=1, updated_at=NOW()
    ");
    $stmt_ch = $db->prepare("
        INSERT INTO chapters (id, course_id, slug, chapter_number, title, description, icon_symbol, xp_reward, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 100, NOW(), NOW())
        ON DUPLICATE KEY UPDATE course_id=VALUES(course_id), slug=VALUES(slug), chapter_number=VALUES(chapter_number),
            title=VALUES(title), description=VALUES(description), icon_symbol=VALUES(icon_symbol), updated_at=NOW()
    ");
    $stmt_l = $db->prepare("
        INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ON DUPLICATE KEY UPDATE chapter_id=VALUES(chapter_id), slug=VALUES(slug), lesson_number=VALUES(lesson_number),
            title=VALUES(title), duration_minutes=VALUES(duration_minutes), xp_reward=VALUES(xp_reward), updated_at=NOW()
    ");

    $courses_n = 0;
    $chapters_n = 0;
    $lessons_n = 0;

    foreach ($curriculum as $c) {
        $cid = (string)($c['id'] ?? '');
        if ($cid === '') continue;

        $stmt_course->execute([
            $cid,
            $ag_id,
            $c['title'] ?? $cid,
            $c['slug'] ?? $cid,
            $c['description'] ?? null,
            $c['image_url'] ?? null,
            $c['accent_color'] ?? null
        ]);
        $courses_n++;

        foreach ($c['chapters'] ?? [] as $ch_idx => $ch) {
            $chid = (string)($ch['id'] ?? '');
            if ($chid === '') continue;
            $ch_num = (int)($ch['chapter_number'] ?? ($ch_idx + 1));
            $stmt_ch->execute([
                $chid,
                $cid,
                $ch['slug'] ?? ('chapter-' . $ch_num),
                $ch_num,
                $ch['title'] ?? ('Chapter ' . $ch_num),
                $ch['description'] ?? null,
                $ch['icon_symbol'] ?? '🚀'
            ]);
            $chapters_n++;

            foreach ($ch['lessons'] ?? [] as $l_idx => $les) {
                $lid = (string)($les['id'] ?? '');
                if ($lid === '') continue;
                $l_num = (int)($les['lesson_number'] ?? ($l_idx + 1));
                $stmt_l->execute([
                    $lid,
                    $chid,
                    $les['slug'] ?? $lid,
                    $l_num,
                    $les['title'] ?? ('Lesson ' . $l_num),
                    (int)($les['duration'] ?? $les['duration_minutes'] ?? 12),
                    (int)($les['xp'] ?? $les['xp_reward'] ?? 25)
                ]);
                $lessons_n++;
            }
        }
        echo "OK course={$cid} chapters=" . count($c['chapters'] ?? []) . "\n";
    }

    echo "Reconcile done. courses={$courses_n} chapters={$chapters_n} lessons={$lessons_n}\n";
} catch (Exception $e) {
    fwrite(STDERR, 'Error: ' . $e->getMessage() . "\n");
    exit(1);
}
