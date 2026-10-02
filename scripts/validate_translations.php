<?php
/**
 * Deterministic bilingual translation completeness validator.
 * Usage: php scripts/validate_translations.php
 * Exit 0 if structural requirements pass; exit 1 on failures.
 */

require_once __DIR__ . '/../config/database.php';

$errors = [];
$warnings = [];

function fail($msg) { global $errors; $errors[] = $msg; }
function warn($msg) { global $warnings; $warnings[] = $msg; }

try {
    $db = get_db_connection();

    // Entity counts
    $courses = (int)$db->query("SELECT COUNT(*) FROM courses WHERE slug IN ('programming-foundations','python-foundations','python-level-2')")->fetchColumn();
    $chapters = (int)$db->query("SELECT COUNT(*) FROM chapters ch JOIN courses c ON c.id=ch.course_id WHERE c.slug IN ('programming-foundations','python-foundations','python-level-2')")->fetchColumn();
    $lessons = (int)$db->query("SELECT COUNT(*) FROM lessons l JOIN chapters ch ON ch.id=l.chapter_id JOIN courses c ON c.id=ch.course_id WHERE c.slug IN ('programming-foundations','python-foundations','python-level-2')")->fetchColumn();
    $exams = (int)$db->query("SELECT COUNT(*) FROM exams e JOIN chapters ch ON ch.id=e.chapter_id JOIN courses c ON c.id=ch.course_id WHERE c.slug IN ('programming-foundations','python-foundations','python-level-2')")->fetchColumn();
    $questions = (int)$db->query("SELECT COUNT(*) FROM questions q JOIN exam_questions eq ON eq.question_id=q.id JOIN exams e ON e.id=eq.exam_id JOIN chapters ch ON ch.id=e.chapter_id JOIN courses c ON c.id=ch.course_id WHERE c.slug IN ('programming-foundations','python-foundations','python-level-2')")->fetchColumn();

    echo "Entity counts: courses=$courses chapters=$chapters lessons=$lessons exams=$exams questions=$questions\n";

    if ($courses !== 3) fail("Expected 3 courses, got $courses");
    if ($chapters !== 26) fail("Expected 26 chapters, got $chapters");
    if ($lessons !== 104) fail("Expected 104 lessons, got $lessons");
    // exams/questions may be 0 if seed_exams not run

    // Translation tables exist?
    foreach (['course_translations','chapter_translations','lesson_translations','lesson_block_translations','exam_translations','question_translations'] as $t) {
        $exists = $db->query("SHOW TABLES LIKE '$t'")->fetch();
        if (!$exists) fail("Missing table $t");
    }

    if (!empty($errors)) {
        echo "FATAL schema issues.\n";
        foreach ($errors as $e) echo "  FAIL: $e\n";
        exit(1);
    }

    // Translation row counts
    $ct_en = (int)$db->query("SELECT COUNT(*) FROM course_translations WHERE language='en'")->fetchColumn();
    $ct_ar = (int)$db->query("SELECT COUNT(*) FROM course_translations WHERE language='ar'")->fetchColumn();
    $ch_en = (int)$db->query("SELECT COUNT(*) FROM chapter_translations WHERE language='en'")->fetchColumn();
    $ch_ar = (int)$db->query("SELECT COUNT(*) FROM chapter_translations WHERE language='ar'")->fetchColumn();
    $ls_en = (int)$db->query("SELECT COUNT(*) FROM lesson_translations WHERE language='en'")->fetchColumn();
    $ls_ar = (int)$db->query("SELECT COUNT(*) FROM lesson_translations WHERE language='ar'")->fetchColumn();
    $bl_en = (int)$db->query("SELECT COUNT(*) FROM lesson_block_translations WHERE language='en'")->fetchColumn();
    $bl_ar = (int)$db->query("SELECT COUNT(*) FROM lesson_block_translations WHERE language='ar'")->fetchColumn();

    echo "Translations: courses en=$ct_en ar=$ct_ar | chapters en=$ch_en ar=$ch_ar | lessons en=$ls_en ar=$ls_ar | blocks en=$bl_en ar=$bl_ar\n";

    if ($ct_en < 3 || $ct_ar < 3) fail("Course translations incomplete");
    if ($ch_en < $chapters || $ch_ar < $chapters) fail("Chapter translations incomplete");
    if ($ls_en < $lessons || $ls_ar < $lessons) fail("Lesson translations incomplete");

    // Empty titles
    $emptyAr = (int)$db->query("SELECT COUNT(*) FROM course_translations WHERE language='ar' AND (title IS NULL OR TRIM(title)='')")->fetchColumn();
    if ($emptyAr > 0) fail("Empty Arabic course titles: $emptyAr");

    // Identical EN/AR lesson titles (likely untranslated)
    $identical = (int)$db->query("
        SELECT COUNT(*) FROM lesson_translations a
        JOIN lesson_translations b ON a.lesson_id = b.lesson_id
        WHERE a.language='en' AND b.language='ar' AND a.title = b.title
    ")->fetchColumn();
    if ($identical > 0) {
        warn("Lesson titles identical EN/AR (likely incomplete translation): $identical");
    }

    // Identical block content (AR not truly translated)
    $identicalBlocks = (int)$db->query("
        SELECT COUNT(*) FROM lesson_block_translations a
        JOIN lesson_block_translations b ON a.lesson_block_id = b.lesson_block_id
        WHERE a.language='en' AND b.language='ar' AND a.content_json = b.content_json
    ")->fetchColumn();
    if ($identicalBlocks > 0) {
        warn("Lesson blocks with identical EN/AR content_json (educational AR incomplete): $identicalBlocks");
    }

    // Orphan translations
    $orphanCourses = (int)$db->query("SELECT COUNT(*) FROM course_translations ct LEFT JOIN courses c ON c.id=ct.course_id WHERE c.id IS NULL")->fetchColumn();
    if ($orphanCourses > 0) fail("Orphan course_translations: $orphanCourses");

    // Duplicate check via unique key assumption — count vs distinct
    $dup = (int)$db->query("
        SELECT COUNT(*) FROM (
            SELECT course_id, language, COUNT(*) c FROM course_translations GROUP BY course_id, language HAVING c > 1
        ) x
    ")->fetchColumn();
    if ($dup > 0) fail("Duplicate course_translations rows: $dup");

    echo "\n=== RESULT ===\n";
    foreach ($errors as $e) echo "FAIL: $e\n";
    foreach ($warnings as $w) echo "WARN: $w\n";

    if (empty($errors)) {
        echo "STRUCTURAL PASS (metadata translation rows present).\n";
        if (!empty($warnings)) {
            echo "CONTENT QUALITY: incomplete Arabic educational text remains (see WARN).\n";
            exit(0); // structural OK
        }
        echo "FULL PASS\n";
        exit(0);
    }
    exit(1);

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
