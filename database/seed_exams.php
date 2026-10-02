<?php
/**
 * SPS Code Orbit — OFFICIAL production exam seed
 *
 * Run AFTER database/seed_curriculum.php so all chapter rows exist.
 * Source: data/production_exams.json (English). Arabic keys: data/production_exams_ar.json
 *   (AR file is used by the exam submit fallback path; this seeder loads the EN JSON into MySQL.)
 *
 * Expected: 37 chapter exams (one per official production chapter).
 * Idempotent upsert by exam id exam-{chapter_id}.
 *
 * Usage:
 *   php database/seed_exams.php
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/helpers.php';

const SPS_EXPECTED_EXAM_COUNT = 37;

try {
    $db = get_db_connection();
    echo "=== SPS Code Orbit — Official exam seed ===\n";
    echo "Source: data/production_exams.json\n\n";

    $json_path = __DIR__ . '/../data/production_exams.json';
    if (!file_exists($json_path)) {
        throw new Exception('Missing data/production_exams.json');
    }
    $payload = json_decode(file_get_contents($json_path), true);
    if (!is_array($payload) || empty($payload['exams']) || !is_array($payload['exams'])) {
        throw new Exception('Invalid production_exams.json structure (expected { "exams": [ ... ] })');
    }

    $exams = $payload['exams'];
    $json_count = count($exams);
    echo "Exams in JSON: {$json_count}\n";
    if ($json_count !== SPS_EXPECTED_EXAM_COUNT) {
        throw new Exception(
            "Expected " . SPS_EXPECTED_EXAM_COUNT . " exams in production_exams.json, found {$json_count}. Refusing partial seed."
        );
    }

    // All chapter ids that should have exams (from official courses in DB)
    $official_course_ids = [
        'course-programming-foundations',
        'course-python-foundations',
        'course-python-level-2',
        'course-javascript-level-1',
        'course-frontend-level-1',
    ];
    $placeholders = implode(',', array_fill(0, count($official_course_ids), '?'));
    $stmt_ch = $db->prepare(
        "SELECT ch.id FROM chapters ch WHERE ch.course_id IN ($placeholders) ORDER BY ch.id"
    );
    $stmt_ch->execute($official_course_ids);
    $db_chapter_ids = $stmt_ch->fetchAll(PDO::FETCH_COLUMN);
    $db_chapter_set = array_flip($db_chapter_ids);

    if (count($db_chapter_ids) !== SPS_EXPECTED_EXAM_COUNT) {
        throw new Exception(
            'Expected ' . SPS_EXPECTED_EXAM_COUNT . ' chapters for official courses in DB, found '
            . count($db_chapter_ids)
            . '. Run php database/seed_curriculum.php first.'
        );
    }

    $exam_chapter_ids = [];
    foreach ($exams as $exam_def) {
        $chapter_id = $exam_def['chapter_id'] ?? '';
        if ($chapter_id === '') {
            throw new Exception('Exam entry missing chapter_id');
        }
        if (isset($exam_chapter_ids[$chapter_id])) {
            throw new Exception("Duplicate exam for chapter_id {$chapter_id}");
        }
        $exam_chapter_ids[$chapter_id] = true;
        if (!isset($db_chapter_set[$chapter_id])) {
            throw new Exception(
                "Exam references chapter not in official DB set: {$chapter_id}. "
                . 'Fix production_exams.json or re-run seed_curriculum.php.'
            );
        }
        if (empty($exam_def['questions']) || !is_array($exam_def['questions'])) {
            throw new Exception("Exam for {$chapter_id} has no questions array");
        }
    }

    $missing_exams = [];
    foreach ($db_chapter_ids as $chid) {
        if (!isset($exam_chapter_ids[$chid])) {
            $missing_exams[] = $chid;
        }
    }
    if ($missing_exams) {
        throw new Exception(
            'Chapters without exam entries in JSON: ' . implode(', ', $missing_exams)
        );
    }

    echo "Validation OK: 37 chapters ↔ 37 exams.\n\n";

    $db->beginTransaction();
    $exams_upserted = 0;
    $questions_upserted = 0;

    foreach ($exams as $exam_def) {
        $chapter_id = $exam_def['chapter_id'];
        $stmt = $db->prepare('SELECT id, title FROM chapters WHERE id = ? LIMIT 1');
        $stmt->execute([$chapter_id]);
        $ch = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$ch) {
            // Should not happen after validation
            throw new Exception("Chapter disappeared during seed: {$chapter_id}");
        }

        $exam_id = 'exam-' . $chapter_id;
        $title = $exam_def['title'] ?? ('Chapter Exam: ' . $ch['title']);
        $description = $exam_def['description'] ?? 'Chapter assessment. Pass threshold: 60%.';

        $db->prepare("
            INSERT INTO exams (id, chapter_id, title, description, passing_score_percent)
            VALUES (?, ?, ?, ?, 60)
            ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                description = VALUES(description),
                passing_score_percent = VALUES(passing_score_percent)
        ")->execute([$exam_id, $chapter_id, $title, $description]);
        $exams_upserted++;

        $old = $db->prepare('SELECT question_id FROM exam_questions WHERE exam_id = ?');
        $old->execute([$exam_id]);
        $old_qids = $old->fetchAll(PDO::FETCH_COLUMN);
        if (!empty($old_qids)) {
            $db->prepare('DELETE FROM exam_questions WHERE exam_id = ?')->execute([$exam_id]);
            foreach ($old_qids as $qid) {
                $db->prepare('DELETE FROM question_answer_keys WHERE question_id = ?')->execute([$qid]);
                $db->prepare('DELETE FROM questions WHERE id = ?')->execute([$qid]);
            }
        }

        $order = 0;
        foreach ($exam_def['questions'] as $qdef) {
            $qtext = $qdef['question_text'] ?? '';
            $options = $qdef['options'] ?? [];
            $correct = $qdef['correct'] ?? 'A';
            $explanation = $qdef['explanation'] ?? '';
            $qtype = strtolower(trim((string) ($qdef['question_type'] ?? 'multiple_choice')));

            // MCQ only — skip essay/coding style entries if any remain in JSON
            if (in_array($qtype, [
                'essay', 'free_text', 'short_answer', 'article', 'text', 'written',
                'output_prediction', 'coding', 'code', 'code_write', 'code_edit',
            ], true)) {
                continue;
            }
            $qtype = 'multiple_choice';

            $qid = $qdef['id'] ?? ('q-' . $chapter_id . '-' . ($order + 1));
            if ($qtext === '') {
                continue;
            }
            if (!is_array($options) || count($options) < 4) {
                continue;
            }
            $options = array_slice($options, 0, 4);
            $junk = false;
            foreach ($options as $opt) {
                $txt = is_array($opt) ? ($opt['text'] ?? '') : (string) $opt;
                if (preg_match('/^Option\s*[A-D]$/i', trim($txt))
                    || in_array(strtolower(trim($txt)), ['world', 'hello', 'test', 'foo', 'bar'], true)
                ) {
                    $junk = true;
                    break;
                }
            }
            if ($junk) {
                continue;
            }
            $order++;

            $options_json = json_encode($options, JSON_UNESCAPED_UNICODE);

            $db->prepare("
                INSERT INTO questions (id, question_text, question_type, options_json, points)
                VALUES (?, ?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE
                    question_text = VALUES(question_text),
                    question_type = VALUES(question_type),
                    options_json = VALUES(options_json),
                    points = VALUES(points)
            ")->execute([$qid, $qtext, $qtype, $options_json]);

            $db->prepare("
                INSERT INTO exam_questions (id, exam_id, question_id, order_index)
                VALUES (?, ?, ?, ?)
            ")->execute([generate_uuid_v4(), $exam_id, $qid, $order]);

            $db->prepare("
                INSERT INTO question_answer_keys (id, question_id, correct_answer, explanation)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    correct_answer = VALUES(correct_answer),
                    explanation = VALUES(explanation)
            ")->execute([
                generate_uuid_v4(),
                $qid,
                json_encode($correct, JSON_UNESCAPED_UNICODE),
                $explanation,
            ]);
            $questions_upserted++;
        }

        if ($order < 1) {
            throw new Exception("Exam for {$chapter_id} produced zero usable MCQ questions after filtering");
        }

        echo "  Exam {$exam_id} — {$order} questions stored\n";
    }

    $db->commit();

    // Post-check: every official chapter has an exam row
    $missing_db = [];
    foreach ($db_chapter_ids as $chid) {
        $ex = $db->prepare('SELECT id FROM exams WHERE chapter_id = ? OR id = ? LIMIT 1');
        $ex->execute([$chid, 'exam-' . $chid]);
        if (!$ex->fetch()) {
            $missing_db[] = $chid;
        }
    }
    if ($missing_db) {
        throw new Exception('After seed, chapters still missing exam rows: ' . implode(', ', $missing_db));
    }

    $e = $db->query('SELECT COUNT(*) c FROM exams')->fetch()['c'];
    $q = $db->query('SELECT COUNT(*) c FROM questions')->fetch()['c'];

    echo "\nExam seed complete (idempotent).\n";
    echo "exams_upserted={$exams_upserted} questions_upserted={$questions_upserted}\n";
    echo "DB totals: exams={$e} questions={$q}\n";
    echo "Expected chapter exams: " . SPS_EXPECTED_EXAM_COUNT . " — OK\n";
} catch (Exception $e) {
    if (isset($db) && $db instanceof PDO && $db->inTransaction()) {
        $db->rollBack();
    }
    echo 'Exam seed error: ' . $e->getMessage() . "
";
    if (PHP_SAPI === 'cli') {
        exit(1);
    }
}
