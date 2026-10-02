<?php
/**
 * SPS Code Orbit — Idempotent bilingual content translation seeder
 *
 * Populates course_translations, chapter_translations, lesson_translations,
 * exam_translations (and EN rows) from existing production entities.
 *
 * - Does NOT create new courses/chapters/lessons
 * - Does NOT touch progress, enrollments, XP, exam attempts
 * - Safe to run multiple times (ON DUPLICATE KEY UPDATE)
 * - Requires migrations 003 + 004 applied
 *
 * Usage (from project root, with DB configured):
 *   php database/seed_translations.php
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

/** @return string */
function tr_uuid() {
    return generate_uuid_v4();
}

/**
 * High-quality Arabic titles for known production entities.
 * Keys are entity IDs. Values are Arabic strings.
 * Extend this map as full lesson-block translations are added.
 */
function arabic_course_map() {
    return [
        'course-programming-foundations' => [
            'title' => 'أساسيات البرمجة — ابدأ من هنا',
            'description' => 'الدورة التأسيسية الكاملة: اكتشف ما هي البرمجة حقًا، وكيف تعمل الحواسيب والإنترنت، وأتقن التفكير الخوارزمي قبل كتابة الكود بأي لغة.',
        ],
        'course-python-foundations' => [
            'title' => 'بايثون المستوى الأول',
            'description' => 'تعلّم أساسيات لغة بايثون: المتغيرات، الأنواع، الشروط، الحلقات، الدوال، والقوائم — من الصفر إلى كتابة برامج حقيقية.',
        ],
        'course-python-level-2' => [
            'title' => 'بايثون المستوى الثاني: Code Orbit',
            'description' => 'تعمّق في بايثون: السلاسل النصية المتقدمة، القواميس، المجموعات، الملفات، والبرمجة المنظمة لبناء مشاريع أقوى.',
        ],
    ];
}

function arabic_chapter_title($english_title, $chapter_id) {
    // Pattern-based quality translations for chapter titles
    $map = [
        'Chapter 1: Technology All Around Us' => 'الفصل 1: التكنولوجيا من حولنا',
        'Chapter 2: What is a Program?' => 'الفصل 2: ما هو البرنامج؟',
        'Chapter 3: Thinking Like a Computer' => 'الفصل 3: فكّر مثل الحاسوب',
        'Chapter 4: Algorithms Everywhere' => 'الفصل 4: الخوارزميات في كل مكان',
        'Chapter 5: From Idea to Code' => 'الفصل 5: من الفكرة إلى الكود',
        'Chapter 6: Your First Real Programs' => 'الفصل 6: برامجك الحقيقية الأولى',
        'The Python Interpreter & Script Execution' => 'مفسّر بايثون وتنفيذ السكربتات',
        'Variables, Types & Memory Binding' => 'المتغيرات والأنواع وربط الذاكرة',
        'Strings — Going Deeper' => 'السلاسل النصية — تعمّق أكثر',
        'Key-Value Storage — Dictionaries' => 'تخزين المفتاح والقيمة — القواميس',
    ];
    if (isset($map[$english_title])) {
        return $map[$english_title];
    }
    // Fallback: prefix chapter number if present
    if (preg_match('/^Chapter\s+(\d+):\s*(.+)$/i', $english_title, $m)) {
        return 'الفصل ' . $m[1] . ': ' . $m[2]; // keep concept in EN if unknown — better than empty
    }
    return $english_title; // detectable: same as EN means needs human review
}

function arabic_lesson_title($english_title) {
    // Common patterns
    $replacements = [
        'Technology in Everyday Life' => 'التكنولوجيا في حياتنا اليومية',
        'Hardware vs Software' => 'العتاد مقابل البرمجيات',
        'Input, Process, Output' => 'المدخلات، المعالجة، المخرجات',
        'Binary: The Language of 0s and 1s' => 'الثنائي: لغة الأصفار والواحدات',
    ];
    foreach ($replacements as $en => $ar) {
        if (stripos($english_title, $en) !== false) {
            // Preserve leading number like "1.1: "
            if (preg_match('/^(\d+\.\d+:\s*)/u', $english_title, $m)) {
                return $m[1] . $ar;
            }
            return $ar;
        }
    }
    return $english_title; // needs review if identical
}

try {
    $db = get_db_connection();
    echo "=== SPS Code Orbit — Translation Seeder ===\n";

    // Ensure translation tables exist (migration 004)
    $check = $db->query("SHOW TABLES LIKE 'course_translations'")->fetch();
    if (!$check) {
        echo "ERROR: course_translations table missing. Apply database/migrations/004_content_translations.sql first.\n";
        exit(1);
    }

    // Preferred language column (migration 003)
    try {
        $db->query("SELECT preferred_language FROM profiles LIMIT 1");
    } catch (Exception $e) {
        echo "WARNING: preferred_language column missing. Apply 003_add_preferred_language.sql\n";
    }

    $db->beginTransaction();

    $courseAr = arabic_course_map();
    $stats = [
        'courses_en' => 0, 'courses_ar' => 0,
        'chapters_en' => 0, 'chapters_ar' => 0,
        'lessons_en' => 0, 'lessons_ar' => 0,
        'exams_en' => 0, 'exams_ar' => 0,
        'blocks_en' => 0, 'blocks_ar' => 0,
        'questions_en' => 0, 'questions_ar' => 0,
    ];

    // ---- COURSES ----
    $courses = $db->query("
        SELECT id, title, description FROM courses
        WHERE slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
        ORDER BY created_at
    ")->fetchAll(PDO::FETCH_ASSOC);

    $upsertCourse = $db->prepare("
        INSERT INTO course_translations (id, course_id, language, title, description)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description)
    ");

    foreach ($courses as $c) {
        $upsertCourse->execute([tr_uuid(), $c['id'], 'en', $c['title'], $c['description']]);
        $stats['courses_en']++;
        $ar = $courseAr[$c['id']] ?? null;
        if ($ar) {
            $upsertCourse->execute([tr_uuid(), $c['id'], 'ar', $ar['title'], $ar['description']]);
            $stats['courses_ar']++;
        } else {
            // Fallback: copy EN so row exists (validator will flag identical text)
            $upsertCourse->execute([tr_uuid(), $c['id'], 'ar', $c['title'], $c['description']]);
            $stats['courses_ar']++;
            echo "  WARN: No curated Arabic for course {$c['id']}\n";
        }
        echo "  Course {$c['id']} EN+AR\n";
    }

    // ---- CHAPTERS ----
    $chapters = $db->query("
        SELECT ch.id, ch.title, ch.description
        FROM chapters ch
        JOIN courses c ON c.id = ch.course_id
        WHERE c.slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
        ORDER BY c.slug, ch.chapter_number
    ")->fetchAll(PDO::FETCH_ASSOC);

    $upsertChapter = $db->prepare("
        INSERT INTO chapter_translations (id, chapter_id, language, title, description)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description)
    ");

    foreach ($chapters as $ch) {
        $upsertChapter->execute([tr_uuid(), $ch['id'], 'en', $ch['title'], $ch['description']]);
        $stats['chapters_en']++;
        $arTitle = arabic_chapter_title($ch['title'], $ch['id']);
        $arDesc = $ch['description']; // full educational AR description can be expanded later
        $upsertChapter->execute([tr_uuid(), $ch['id'], 'ar', $arTitle, $arDesc]);
        $stats['chapters_ar']++;
    }
    echo "  Chapters: " . count($chapters) . " × EN+AR\n";

    // ---- LESSONS ----
    $lessons = $db->query("
        SELECT l.id, l.title
        FROM lessons l
        JOIN chapters ch ON ch.id = l.chapter_id
        JOIN courses c ON c.id = ch.course_id
        WHERE c.slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
        ORDER BY c.slug, ch.chapter_number, l.lesson_number
    ")->fetchAll(PDO::FETCH_ASSOC);

    $upsertLesson = $db->prepare("
        INSERT INTO lesson_translations (id, lesson_id, language, title, subtitle, description)
        VALUES (?, ?, ?, ?, NULL, NULL)
        ON DUPLICATE KEY UPDATE title = VALUES(title)
    ");

    foreach ($lessons as $l) {
        $upsertLesson->execute([tr_uuid(), $l['id'], 'en', $l['title']]);
        $stats['lessons_en']++;
        $arTitle = arabic_lesson_title($l['title']);
        $upsertLesson->execute([tr_uuid(), $l['id'], 'ar', $arTitle]);
        $stats['lessons_ar']++;
    }
    echo "  Lessons: " . count($lessons) . " × EN+AR\n";

    // ---- LESSON BLOCKS: copy EN content_json; AR starts as copy (detectable) until full translation pass ----
    $blocks = $db->query("
        SELECT lb.id, lb.content_json
        FROM lesson_blocks lb
        JOIN lessons l ON l.id = lb.lesson_id
        JOIN chapters ch ON ch.id = l.chapter_id
        JOIN courses c ON c.id = ch.course_id
        WHERE c.slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
    ")->fetchAll(PDO::FETCH_ASSOC);

    $upsertBlock = $db->prepare("
        INSERT INTO lesson_block_translations (id, lesson_block_id, language, content_json)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE content_json = VALUES(content_json)
    ");

    foreach ($blocks as $b) {
        $upsertBlock->execute([tr_uuid(), $b['id'], 'en', $b['content_json']]);
        $stats['blocks_en']++;
        // AR: for now store English content so structure is complete; full AR educational text is Phase 2b
        // Validator will flag identical EN/AR content_json as incomplete translation
        $upsertBlock->execute([tr_uuid(), $b['id'], 'ar', $b['content_json']]);
        $stats['blocks_ar']++;
    }
    echo "  Lesson blocks: " . count($blocks) . " × EN+AR (AR content still needs full educational translation)\n";

    // ---- EXAMS + QUESTIONS from production_exams.json + production_exams_ar.json ----
    // Authoritative bilingual content: same question IDs / correct keys; only visible text differs.
    $arExamPath = __DIR__ . '/../data/production_exams_ar.json';
    $enExamPath = __DIR__ . '/../data/production_exams.json';
    $arExamByChapter = [];
    $enExamByChapter = [];
    if (file_exists($arExamPath)) {
        $arPayload = json_decode(file_get_contents($arExamPath), true);
        if (!empty($arPayload['exams']) && is_array($arPayload['exams'])) {
            foreach ($arPayload['exams'] as $ex) {
                if (!empty($ex['chapter_id'])) {
                    $arExamByChapter[$ex['chapter_id']] = $ex;
                }
            }
        }
    }
    if (file_exists($enExamPath)) {
        $enPayload = json_decode(file_get_contents($enExamPath), true);
        if (!empty($enPayload['exams']) && is_array($enPayload['exams'])) {
            foreach ($enPayload['exams'] as $ex) {
                if (!empty($ex['chapter_id'])) {
                    $enExamByChapter[$ex['chapter_id']] = $ex;
                }
            }
        }
    }
    echo "  Loaded production exam AR maps: " . count($arExamByChapter) . " chapters\n";

    $exams = $db->query("
        SELECT e.id, e.title, e.description, e.chapter_id
        FROM exams e
        JOIN chapters ch ON ch.id = e.chapter_id
        JOIN courses c ON c.id = ch.course_id
        WHERE c.slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
    ")->fetchAll(PDO::FETCH_ASSOC);

    $upsertExam = $db->prepare("
        INSERT INTO exam_translations (id, exam_id, language, title, description, instructions)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description), instructions = VALUES(instructions)
    ");

    $instrEnDefault = 'Answer all questions. Passing score is 60%. You have up to 3 attempts.';
    $instrArDefault = 'أجب عن جميع الأسئلة. درجة النجاح 60٪. لديك حتى 3 محاولات.';

    foreach ($exams as $e) {
        $cid = $e['chapter_id'];
        $enDef = $enExamByChapter[$cid] ?? null;
        $arDef = $arExamByChapter[$cid] ?? null;

        $enTitle = $enDef['title'] ?? $e['title'];
        $enDesc = $enDef['description'] ?? $e['description'];
        $enInstr = $enDef['instructions'] ?? $instrEnDefault;

        $upsertExam->execute([tr_uuid(), $e['id'], 'en', $enTitle, $enDesc, $enInstr]);
        $stats['exams_en']++;

        if ($arDef) {
            $arTitle = $arDef['title'] ?? ('اختبار الفصل: ' . preg_replace('/^Chapter Exam:\s*/i', '', $enTitle));
            $arDesc = $arDef['description'] ?? $enDesc;
            $arInstr = $arDef['instructions'] ?? $instrArDefault;
        } else {
            // Fallback patterned AR title when AR JSON missing for this chapter
            $arTitle = 'اختبار الفصل: ' . preg_replace('/^Chapter Exam:\s*/i', '', $enTitle);
            $arDesc = $enDesc;
            $arInstr = $instrArDefault;
        }
        $upsertExam->execute([tr_uuid(), $e['id'], 'ar', $arTitle, $arDesc, $arInstr]);
        $stats['exams_ar']++;
    }
    echo "  Exams: " . count($exams) . " × EN+AR\n";

    // ---- QUESTIONS (EN from DB base; AR from production_exams_ar.json by question id) ----
    $questions = $db->query("
        SELECT q.id, q.question_text, q.options_json
        FROM questions q
        JOIN exam_questions eq ON eq.question_id = q.id
        JOIN exams e ON e.id = eq.exam_id
        JOIN chapters ch ON ch.id = e.chapter_id
        JOIN courses c ON c.id = ch.course_id
        WHERE c.slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Build AR question map: question_id => {question_text, options, explanation}
    $arQuestionMap = [];
    foreach ($arExamByChapter as $ex) {
        foreach (($ex['questions'] ?? []) as $q) {
            if (empty($q['id'])) continue;
            $opts = $q['options'] ?? [];
            // Normalize options to same shape seed_exams stores in questions.options_json
            $normalized = [];
            foreach ($opts as $opt) {
                if (is_array($opt)) {
                    $normalized[] = [
                        'key' => $opt['key'] ?? '',
                        'text' => $opt['text'] ?? '',
                    ];
                } else {
                    $normalized[] = ['key' => '', 'text' => (string)$opt];
                }
            }
            $arQuestionMap[$q['id']] = [
                'question_text' => $q['question_text'] ?? '',
                'options_json' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
                'explanation' => $q['explanation'] ?? '',
            ];
        }
    }
    echo "  AR question map size: " . count($arQuestionMap) . "\n";

    $upsertQ = $db->prepare("
        INSERT INTO question_translations (id, question_id, language, question_text, options_json)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE question_text = VALUES(question_text), options_json = VALUES(options_json)
    ");

    $pf_ar_applied = 0;
    $ar_fallback_en = 0;
    foreach ($questions as $q) {
        $upsertQ->execute([tr_uuid(), $q['id'], 'en', $q['question_text'], $q['options_json']]);
        $stats['questions_en']++;

        if (isset($arQuestionMap[$q['id']]) && $arQuestionMap[$q['id']]['question_text'] !== '') {
            $arQ = $arQuestionMap[$q['id']];
            $upsertQ->execute([tr_uuid(), $q['id'], 'ar', $arQ['question_text'], $arQ['options_json']]);
            $pf_ar_applied++;
        } else {
            // Keep EN as temporary AR only when no translation exists (other courses not yet localized)
            $upsertQ->execute([tr_uuid(), $q['id'], 'ar', $q['question_text'], $q['options_json']]);
            $ar_fallback_en++;
        }
        $stats['questions_ar']++;
    }
    echo "  Questions: " . count($questions) . " × EN+AR (real AR applied: {$pf_ar_applied}, EN-fallback: {$ar_fallback_en})\n";

    // ---- Answer-key explanations (AR) for review mode ----
    try {
        $keys = $db->query("
            SELECT k.id AS key_id, k.question_id, k.explanation
            FROM question_answer_keys k
            JOIN exam_questions eq ON eq.question_id = k.question_id
            JOIN exams e ON e.id = eq.exam_id
            JOIN chapters ch ON ch.id = e.chapter_id
            JOIN courses c ON c.id = ch.course_id
            WHERE c.slug IN ('programming-foundations', 'python-foundations', 'python-level-2')
        ")->fetchAll(PDO::FETCH_ASSOC);

        $upsertKeyTr = $db->prepare("
            INSERT INTO question_answer_key_translations (id, question_answer_key_id, language, explanation)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE explanation = VALUES(explanation)
        ");
        $key_ar = 0;
        foreach ($keys as $k) {
            $upsertKeyTr->execute([tr_uuid(), $k['key_id'], 'en', $k['explanation']]);
            $arExp = $arQuestionMap[$k['question_id']]['explanation'] ?? $k['explanation'];
            $upsertKeyTr->execute([tr_uuid(), $k['key_id'], 'ar', $arExp]);
            if (isset($arQuestionMap[$k['question_id']]['explanation']) && $arQuestionMap[$k['question_id']]['explanation'] !== '') {
                $key_ar++;
            }
        }
        echo "  Answer-key explanations: " . count($keys) . " × EN+AR (real AR: {$key_ar})\n";
    } catch (Exception $e) {
        echo "  Answer-key translations skipped: " . $e->getMessage() . "\n";
    }

    $db->commit();

    echo "\n=== Seed stats ===\n";
    foreach ($stats as $k => $v) {
        echo "  $k: $v\n";
    }
    echo "\nDone. Re-run is safe (idempotent).\n";
    echo "NOTE: Programming Foundations exam AR is loaded from data/production_exams_ar.json.\n";
    echo "Other courses keep EN as AR placeholder until their dedicated translation pass.\n";

} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
