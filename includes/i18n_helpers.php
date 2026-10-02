<?php
/**
 * SPS Code Orbit — Language resolution & content translation helpers
 * Used by PHP APIs. Does not affect progress, enrollment, or grading.
 */

/**
 * Resolve requested language from query/body, then user preference, then browser-like header, then 'en'.
 * Allowed: en, ar only.
 */
function resolve_request_language($user = null) {
    $allowed = ['en', 'ar'];

    // 1. Explicit request param
    $req = null;
    if (isset($_GET['lang'])) {
        $req = strtolower(trim((string)$_GET['lang']));
    } elseif (isset($_GET['language'])) {
        $req = strtolower(trim((string)$_GET['language']));
    }
    if ($req && in_array($req, $allowed, true)) {
        return $req;
    }

    // 2. Authenticated user preferred_language (from session or DB)
    if ($user && !empty($user['preferred_language'])) {
        $pl = strtolower(trim((string)$user['preferred_language']));
        if (in_array($pl, $allowed, true)) {
            return $pl;
        }
    }

    // 3. Accept-Language header (simple)
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $al = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        if (strpos($al, 'ar') === 0 || strpos($al, 'ar,') !== false || strpos($al, 'ar-') !== false) {
            return 'ar';
        }
    }

    return 'en';
}

/**
 * Load preferred_language into user array from DB if missing.
 */
function enrich_user_language($db, $user) {
    if (!$user || empty($user['id'])) {
        return $user;
    }
    if (!empty($user['preferred_language'])) {
        return $user;
    }
    try {
        $stmt = $db->prepare("SELECT preferred_language FROM profiles WHERE id = ? LIMIT 1");
        $stmt->execute([$user['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && !empty($row['preferred_language'])) {
            $user['preferred_language'] = $row['preferred_language'];
        } else {
            $user['preferred_language'] = 'en';
        }
    } catch (Exception $e) {
        $user['preferred_language'] = 'en';
    }
    return $user;
}

/**
 * Apply course translation fields onto a course row (mutates array).
 * Falls back to original English fields if translation missing.
 */
function apply_course_translation($db, array &$course, $lang) {
    if ($lang === 'en' || empty($course['id'])) {
        return;
    }
    try {
        $stmt = $db->prepare("SELECT title, description FROM course_translations WHERE course_id = ? AND language = ? LIMIT 1");
        $stmt->execute([$course['id'], $lang]);
        $tr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tr) {
            if (!empty($tr['title'])) $course['title'] = $tr['title'];
            if (isset($tr['description']) && $tr['description'] !== null && $tr['description'] !== '') {
                $course['description'] = $tr['description'];
            }
        }
    } catch (Exception $e) {
        // table may not exist yet — keep English
    }
}

function apply_chapter_translation($db, array &$chapter, $lang) {
    if ($lang === 'en' || empty($chapter['id'])) {
        return;
    }
    try {
        $stmt = $db->prepare("SELECT title, description FROM chapter_translations WHERE chapter_id = ? AND language = ? LIMIT 1");
        $stmt->execute([$chapter['id'], $lang]);
        $tr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tr) {
            if (!empty($tr['title'])) $chapter['title'] = $tr['title'];
            if (isset($tr['description']) && $tr['description'] !== null && $tr['description'] !== '') {
                $chapter['description'] = $tr['description'];
            }
        }
    } catch (Exception $e) {}
}

function apply_lesson_translation($db, array &$lesson, $lang) {
    if ($lang === 'en' || empty($lesson['id'])) {
        return;
    }
    try {
        $stmt = $db->prepare("SELECT title, subtitle, description FROM lesson_translations WHERE lesson_id = ? AND language = ? LIMIT 1");
        $stmt->execute([$lesson['id'], $lang]);
        $tr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tr) {
            if (!empty($tr['title'])) $lesson['title'] = $tr['title'];
            if (!empty($tr['subtitle'])) $lesson['subtitle'] = $tr['subtitle'];
            if (isset($tr['description']) && $tr['description'] !== null && $tr['description'] !== '') {
                $lesson['description'] = $tr['description'];
            }
        }
    } catch (Exception $e) {}
}

/**
 * Load lesson blocks with optional language-specific content_json from lesson_block_translations.
 * Returns array of blocks (id, block_type, order_index, content_json decoded or raw as stored by caller).
 */
function load_lesson_blocks_translated($db, $lesson_id, $lang = 'en') {
    $stmt = $db->prepare("
        SELECT id, block_type, order_index, content_json
        FROM lesson_blocks
        WHERE lesson_id = ?
        ORDER BY order_index ASC
    ");
    $stmt->execute([$lesson_id]);
    $blocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($lang === 'en' || empty($blocks)) {
        return $blocks;
    }

    try {
        $ids = array_column($blocks, 'id');
        if (empty($ids)) return $blocks;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $params = $ids;
        $params[] = $lang;
        $trStmt = $db->prepare("
            SELECT lesson_block_id, content_json
            FROM lesson_block_translations
            WHERE lesson_block_id IN ($placeholders) AND language = ?
        ");
        $trStmt->execute($params);
        $map = [];
        while ($row = $trStmt->fetch(PDO::FETCH_ASSOC)) {
            $map[$row['lesson_block_id']] = $row['content_json'];
        }
        foreach ($blocks as &$b) {
            if (isset($map[$b['id']]) && $map[$b['id']] !== null && $map[$b['id']] !== '') {
                $b['content_json'] = $map[$b['id']];
            }
        }
        unset($b);
    } catch (Exception $e) {
        // keep English blocks
    }
    return $blocks;
}

function apply_exam_translation($db, array &$exam, $lang) {
    if ($lang === 'en' || empty($exam['id'])) {
        return;
    }
    try {
        $stmt = $db->prepare("SELECT title, description, instructions FROM exam_translations WHERE exam_id = ? AND language = ? LIMIT 1");
        $stmt->execute([$exam['id'], $lang]);
        $tr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tr) {
            if (!empty($tr['title'])) $exam['title'] = $tr['title'];
            if (isset($tr['description']) && $tr['description'] !== '') $exam['description'] = $tr['description'];
            if (isset($tr['instructions']) && $tr['instructions'] !== '') $exam['instructions'] = $tr['instructions'];
        }
    } catch (Exception $e) {}
}

function apply_question_translation($db, array &$question, $lang) {
    if ($lang === 'en' || empty($question['id'])) {
        return;
    }
    try {
        $stmt = $db->prepare("SELECT question_text, options_json FROM question_translations WHERE question_id = ? AND language = ? LIMIT 1");
        $stmt->execute([$question['id'], $lang]);
        $tr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tr) {
            if (!empty($tr['question_text'])) $question['question_text'] = $tr['question_text'];
            if (isset($tr['options_json']) && $tr['options_json'] !== null && $tr['options_json'] !== '') {
                $question['options_json'] = $tr['options_json'];
            }
        }
    } catch (Exception $e) {}
}


/**
 * Apply Arabic (or other) explanation from question_answer_key_translations.
 * Does not change correct_answer keys — grading identity stays language-independent.
 */
function apply_answer_key_explanation_translation($db, $question_id, $lang, $fallback_explanation = '') {
    if ($lang === 'en' || empty($question_id)) {
        return $fallback_explanation;
    }
    try {
        $stmt = $db->prepare("
            SELECT t.explanation
            FROM question_answer_key_translations t
            JOIN question_answer_keys k ON k.id = t.question_answer_key_id
            WHERE k.question_id = ? AND t.language = ?
            LIMIT 1
        ");
        $stmt->execute([$question_id, $lang]);
        $tr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($tr && isset($tr['explanation']) && $tr['explanation'] !== '') {
            return $tr['explanation'];
        }
    } catch (Exception $e) {}
    return $fallback_explanation;
}


/**
 * Overlay exam title/questions from production_exams[_ar].json when DB rows are English-only.
 * Matches by chapter_id + question id (preferred) or order index. Never changes correct keys.
 */
function overlay_exam_questions_from_json(array &$exam, array &$questions, $lang) {
    if ($lang !== 'ar' || empty($questions)) {
        return;
    }
    $json_path = __DIR__ . '/../data/production_exams_ar.json';
    if (!file_exists($json_path)) {
        return;
    }
    $payload = json_decode(file_get_contents($json_path), true);
    if (empty($payload['exams']) || !is_array($payload['exams'])) {
        return;
    }
    $chapter_id = (string)($exam['chapter_id'] ?? '');
    if ($chapter_id === '') {
        return;
    }
    $want = $chapter_id;
    $want_clean = preg_replace('/^exam-/', '', $want);
    $found = null;
    foreach ($payload['exams'] as $ex) {
        $ex_ch = (string)($ex['chapter_id'] ?? '');
        if ($ex_ch === $want || $ex_ch === $want_clean || ('exam-' . $ex_ch) === $want) {
            $found = $ex;
            break;
        }
    }
    if (!$found || empty($found['questions']) || !is_array($found['questions'])) {
        return;
    }
    if (!empty($found['title'])) {
        $exam['title'] = $found['title'];
    }
    if (!empty($found['description'])) {
        $exam['description'] = $found['description'];
    }
    if (!empty($found['instructions'])) {
        $exam['instructions'] = $found['instructions'];
    }

    $by_id = [];
    foreach ($found['questions'] as $idx => $qdef) {
        $qid = (string)($qdef['id'] ?? '');
        if ($qid !== '') {
            $by_id[$qid] = $qdef;
        }
        $by_id['__ord_' . ($idx + 1)] = $qdef;
    }

    foreach ($questions as $i => &$q) {
        $qid = (string)($q['id'] ?? '');
        $qdef = null;
        if ($qid !== '' && isset($by_id[$qid])) {
            $qdef = $by_id[$qid];
        } else {
            $ord = (int)($q['order_index'] ?? ($i + 1));
            $qdef = $by_id['__ord_' . $ord] ?? null;
        }
        if (!$qdef) {
            continue;
        }
        if (!empty($qdef['question_text'])) {
            $q['question_text'] = $qdef['question_text'];
        }
        if (!empty($qdef['explanation']) && array_key_exists('explanation', $q)) {
            $q['explanation'] = $qdef['explanation'];
        }
        $opts_in = $qdef['options'] ?? null;
        if (!is_array($opts_in) || empty($opts_in)) {
            continue;
        }
        // Build map key => text from AR file
        $ar_map = [];
        foreach ($opts_in as $opt) {
            if (is_array($opt)) {
                $k = (string)($opt['key'] ?? '');
                $txt = (string)($opt['text'] ?? '');
                if ($k !== '' && $txt !== '') {
                    $ar_map[$k] = $txt;
                }
            }
        }
        if (empty($ar_map) || empty($q['options']) || !is_array($q['options'])) {
            continue;
        }
        foreach ($q['options'] as &$opt) {
            $k = (string)($opt['key'] ?? '');
            if ($k !== '' && isset($ar_map[$k])) {
                $opt['text'] = $ar_map[$k];
            }
        }
        unset($opt);
    }
    unset($q);
}
