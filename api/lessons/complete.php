<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/student.php';
require_once __DIR__ . '/../../middleware/csrf.php';
require_once __DIR__ . '/../../includes/achievements_helpers.php';

require_post_method();
$user = require_student();
verify_csrf_token();

$data = get_json_request();
$lesson_id = trim($data['lesson_id'] ?? '');

if (empty($lesson_id)) {
    error_response('Lesson ID is required', 400);
}

try {
    $db = get_db_connection();
    $user_id = $user['id'];

    // 1. Fetch lesson details & chapter & course (MySQL is authoritative)
    $stmt = $db->prepare("
        SELECT l.id, l.title, l.xp_reward, l.chapter_id, l.lesson_number, l.slug,
               c.course_id, c.chapter_number, c.xp_reward as chapter_xp
        FROM lessons l
        JOIN chapters c ON l.chapter_id = c.id
        WHERE l.id = ? OR l.slug = ?
    ");
    $stmt->execute([$lesson_id, $lesson_id]);
    $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fallback: if lesson row is missing (new courses shipped via curriculum export
    // before/without full SQL import), resolve from curriculum_export.json and
    // upsert course/chapter/lesson so progress FKs and sequential unlock work.
    if (!$lesson) {
        $export_file = __DIR__ . '/../../data/curriculum_export.json';
        $export_lesson = null;
        $export_chapter = null;
        $export_course = null;
        if (file_exists($export_file)) {
            $export_courses = json_decode(file_get_contents($export_file), true);
            if (is_array($export_courses)) {
                foreach ($export_courses as $ec) {
                    foreach (($ec['chapters'] ?? []) as $ech) {
                        foreach (($ech['lessons'] ?? []) as $eles) {
                            $lid = (string)($eles['id'] ?? '');
                            $lslug = (string)($eles['slug'] ?? '');
                            if ($lid === $lesson_id || $lslug === $lesson_id || strcasecmp($lid, $lesson_id) === 0) {
                                $export_lesson = $eles;
                                $export_chapter = $ech;
                                $export_course = $ec;
                                break 3;
                            }
                        }
                    }
                }
            }
        }
        if (!$export_lesson || !$export_course || !$export_chapter) {
            error_response('Lesson not found', 404);
        }

        $course_id_candidate = (string)($export_course['id'] ?? '');
        $chapter_id_candidate = (string)($export_chapter['id'] ?? '');
        $lesson_id_canonical = (string)($export_lesson['id'] ?? $lesson_id);

        // Ensure course row exists
        $stmt_co = $db->prepare("SELECT id FROM courses WHERE id = ? OR slug = ? LIMIT 1");
        $stmt_co->execute([$course_id_candidate, $export_course['slug'] ?? '']);
        $co_row = $stmt_co->fetch(PDO::FETCH_ASSOC);
        if ($co_row) {
            $course_id_candidate = $co_row['id'];
        } else {
            $ag_id = null;
            try {
                $ag_id = $db->query("SELECT id FROM academic_groups ORDER BY name LIMIT 1")->fetchColumn() ?: null;
            } catch (\Throwable $e) {}
            $db->prepare("
                INSERT INTO courses (id, academic_group_id, title, slug, description, image_url, accent_color, is_published, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
                ON DUPLICATE KEY UPDATE title=VALUES(title), slug=VALUES(slug), is_published=1, updated_at=NOW()
            ")->execute([
                $course_id_candidate,
                $ag_id,
                $export_course['title'] ?? 'Course',
                $export_course['slug'] ?? $course_id_candidate,
                $export_course['description'] ?? null,
                $export_course['image_url'] ?? null,
                $export_course['accent_color'] ?? null
            ]);
        }

        // Ensure chapter row exists
        $stmt_ch = $db->prepare("SELECT id, chapter_number, xp_reward FROM chapters WHERE id = ? OR (course_id = ? AND chapter_number = ?) LIMIT 1");
        $ch_num = (int)($export_chapter['chapter_number'] ?? 1);
        $stmt_ch->execute([$chapter_id_candidate, $course_id_candidate, $ch_num]);
        $ch_row = $stmt_ch->fetch(PDO::FETCH_ASSOC);
        if ($ch_row) {
            $chapter_id_candidate = $ch_row['id'];
            $chapter_xp = (int)($ch_row['xp_reward'] ?? 50);
            $ch_num = (int)($ch_row['chapter_number'] ?? $ch_num);
        } else {
            $chapter_xp = (int)($export_chapter['xp_reward'] ?? 50);
            $db->prepare("
                INSERT INTO chapters (id, course_id, slug, chapter_number, title, description, icon_symbol, xp_reward, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ON DUPLICATE KEY UPDATE course_id=VALUES(course_id), chapter_number=VALUES(chapter_number), title=VALUES(title), updated_at=NOW()
            ")->execute([
                $chapter_id_candidate,
                $course_id_candidate,
                $export_chapter['slug'] ?? ('chapter-' . $ch_num),
                $ch_num,
                $export_chapter['title'] ?? ('Chapter ' . $ch_num),
                $export_chapter['description'] ?? null,
                $export_chapter['icon_symbol'] ?? '🚀',
                $chapter_xp
            ]);
        }

        // Upsert lesson so lesson_progress FK succeeds
        $l_num = (int)($export_lesson['lesson_number'] ?? 1);
        $l_title = $export_lesson['title'] ?? 'Lesson';
        $l_slug = $export_lesson['slug'] ?? $lesson_id_canonical;
        $l_xp = (int)($export_lesson['xp'] ?? $export_lesson['xp_reward'] ?? 25);
        $l_dur = (int)($export_lesson['duration'] ?? $export_lesson['duration_minutes'] ?? 12);
        $db->prepare("
            INSERT INTO lessons (id, chapter_id, slug, lesson_number, title, duration_minutes, xp_reward, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE chapter_id=VALUES(chapter_id), slug=VALUES(slug), lesson_number=VALUES(lesson_number),
                title=VALUES(title), duration_minutes=VALUES(duration_minutes), xp_reward=VALUES(xp_reward), updated_at=NOW()
        ")->execute([$lesson_id_canonical, $chapter_id_candidate, $l_slug, $l_num, $l_title, $l_dur, $l_xp]);

        // Prefer canonical id from export for subsequent progress writes
        $lesson_id = $lesson_id_canonical;
        $lesson = [
            'id' => $lesson_id_canonical,
            'title' => $l_title,
            'xp_reward' => $l_xp,
            'chapter_id' => $chapter_id_candidate,
            'lesson_number' => $l_num,
            'slug' => $l_slug,
            'course_id' => $course_id_candidate,
            'chapter_number' => $ch_num,
            'chapter_xp' => $chapter_xp ?? 50,
        ];
    }

    $chapter_id = $lesson['chapter_id'];
    $course_id = $lesson['course_id'];
    // Keep request lesson_id aligned with DB canonical id
    $lesson_id = $lesson['id'];

    // Confirm enrollment
    $stmt_enroll = $db->prepare("SELECT id FROM course_enrollments WHERE course_id = ? AND user_id = ?");
    $stmt_enroll->execute([$course_id, $user_id]);
    if (!$stmt_enroll->fetch()) {
        error_response('Forbidden. You are not enrolled in this course.', 403);
    }

    // --- SERVER SIDE SEQUENTIAL UNLOCK VALIDATION FOR LESSON COMPLETION ---
    $stmt_first_ch = $db->prepare("SELECT id FROM chapters WHERE course_id = ? ORDER BY chapter_number ASC LIMIT 1");
    $stmt_first_ch->execute([$course_id]);
    $first_chapter_id = $stmt_first_ch->fetchColumn();

    $stmt_first_les = $db->prepare("SELECT id FROM lessons WHERE chapter_id = ? ORDER BY lesson_number ASC LIMIT 1");
    $stmt_first_les->execute([$chapter_id]);
    $first_lesson_id = $stmt_first_les->fetchColumn();

    $lesson_num = (int)($lesson['lesson_number'] ?? 0);
    $chapter_num = (int)($lesson['chapter_number'] ?? 0);
    $is_first_lesson_of_course = (
        ($chapter_id && $first_chapter_id && $chapter_id === $first_chapter_id && $lesson['id'] === $first_lesson_id)
        || ($chapter_num === 1 && $lesson_num === 1)
    );

    if (!$is_first_lesson_of_course) {
        if ($lesson['id'] === $first_lesson_id || $lesson_num === 1) {
            // First lesson of subsequent chapter: Check if previous chapter exam is passed (or lessons completed if no exam)
            $stmt_prev_ch = $db->prepare("
                SELECT id FROM chapters 
                WHERE course_id = ? AND chapter_number < ? 
                ORDER BY chapter_number DESC LIMIT 1
            ");
            $stmt_prev_ch->execute([$course_id, $lesson['chapter_number']]);
            $prev_chapter_id = $stmt_prev_ch->fetchColumn();

            if ($prev_chapter_id) {
                // Check 1: Is chapter_progress marked 'completed' for this user & chapter?
                $stmt_cp = $db->prepare("SELECT id FROM chapter_progress WHERE user_id = ? AND chapter_id = ? AND status = 'completed'");
                $stmt_cp->execute([$user_id, $prev_chapter_id]);
                $prev_cp_completed = (bool)$stmt_cp->fetch();

                if (!$prev_cp_completed) {
                    // Check 2: Does a passing exam attempt exist for the previous chapter?
                    $stmt_prev_exam = $db->prepare("SELECT id FROM exams WHERE chapter_id = ? LIMIT 1");
                    $stmt_prev_exam->execute([$prev_chapter_id]);
                    $prev_exam_id = $stmt_prev_exam->fetchColumn();

                    $stmt_pass = $db->prepare("
                        SELECT id FROM exam_attempts 
                        WHERE user_id = ? AND (passed = 1 OR score >= 60) AND (
                            exam_id = ? OR 
                            exam_id = ? OR 
                            exam_id = ? OR 
                            exam_id IN (SELECT id FROM exams WHERE chapter_id = ?)
                        )
                    ");
                    $stmt_pass->execute([
                        $user_id,
                        $prev_exam_id ?: '',
                        $prev_chapter_id,
                        'exam-' . $prev_chapter_id,
                        $prev_chapter_id
                    ]);
                    $prev_exam_passed = (bool)$stmt_pass->fetch();

                    if (!$prev_exam_passed) {
                        if (!$prev_exam_id) {
                            $stmt_uncomp = $db->prepare("
                                SELECT COUNT(l.id) FROM lessons l
                                LEFT JOIN lesson_progress lp ON l.id = lp.lesson_id AND lp.user_id = ? AND lp.status = 'completed'
                                WHERE l.chapter_id = ? AND lp.id IS NULL
                            ");
                            $stmt_uncomp->execute([$user_id, $prev_chapter_id]);
                            if ((int)$stmt_uncomp->fetchColumn() > 0) {
                                error_response('Chapter locked. Complete all lessons of the previous chapter first.', 403);
                            }
                        } else {
                            error_response('Chapter locked. You must pass the previous chapter exam to unlock this chapter.', 403);
                        }
                    }
                }
            }
        } else {
            // Subsequent lesson of current chapter: check if previous lesson is completed
            $stmt_prev_les = $db->prepare("
                SELECT id FROM lessons 
                WHERE chapter_id = ? AND lesson_number < ? 
                ORDER BY lesson_number DESC LIMIT 1
            ");
            $stmt_prev_les->execute([$chapter_id, $lesson['lesson_number']]);
            $prev_lesson_id = $stmt_prev_les->fetchColumn();
            
            if ($prev_lesson_id) {
                $stmt_lp_check = $db->prepare("SELECT id FROM lesson_progress WHERE user_id = ? AND lesson_id = ? AND status = 'completed'");
                $stmt_lp_check->execute([$user_id, $prev_lesson_id]);
                if (!$stmt_lp_check->fetch()) {
                    error_response('Lesson locked. You must complete the previous lesson first.', 403);
                }
            }
        }
    }

    // 2. Mark lesson as completed in lesson_progress
    $check_lp = $db->prepare("SELECT id, status FROM lesson_progress WHERE user_id = ? AND lesson_id = ?");
    $check_lp->execute([$user_id, $lesson_id]);
    $existing_lp = $check_lp->fetch();

    $already_completed = ($existing_lp && $existing_lp['status'] === 'completed');

    if ($already_completed) {
        $gam_stmt = $db->prepare("SELECT total_xp, current_streak FROM student_gamification WHERE user_id = ?");
        $gam_stmt->execute([$user_id]);
        $gam = $gam_stmt->fetch() ?: ['total_xp' => 0, 'current_streak' => 0];

        success_response([
            'lesson_id' => $lesson_id,
            'xp_awarded' => 0,
            'already_completed' => true,
            'total_xp' => (int)$gam['total_xp'],
            'streak' => (int)$gam['current_streak'],
            'unlocked_achievements' => []
        ]);
        return;
    }

    if ($existing_lp) {
        $upd_lp = $db->prepare("UPDATE lesson_progress SET status = 'completed', completed_at = IFNULL(completed_at, NOW()) WHERE id = ?");
        $upd_lp->execute([$existing_lp['id']]);
    } else {
        $ins_lp = $db->prepare("INSERT INTO lesson_progress (id, user_id, lesson_id, status, started_at, completed_at) VALUES (?, ?, ?, 'completed', NOW(), NOW())");
        $ins_lp->execute([generate_uuid_v4(), $user_id, $lesson_id]);
    }

    $xp_awarded = 0;
    $unlocked_achievements = [];

    // 3. Award XP only if this is the first time completing this lesson
    if (!$already_completed) {
        $check_xp = $db->prepare("SELECT id FROM xp_events WHERE user_id = ? AND source_type = 'lesson' AND source_id = ?");
        $check_xp->execute([$user_id, $lesson_id]);
        if (!$check_xp->fetch()) {
            $lesson_xp = (int)($lesson['xp_reward'] ?? 20);
            $ins_xp = $db->prepare("INSERT INTO xp_events (id, user_id, amount, source_type, source_id) VALUES (?, ?, ?, 'lesson', ?)");
            $ins_xp->execute([generate_uuid_v4(), $user_id, $lesson_xp, $lesson_id]);
            $xp_awarded += $lesson_xp;
        }
    }

    // 4. Update student streak and gamification table
    $gam_stmt = $db->prepare("SELECT id, total_xp, current_streak, longest_streak, last_activity_date FROM student_gamification WHERE user_id = ?");
    $gam_stmt->execute([$user_id]);
    $gam = $gam_stmt->fetch();

    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    if ($gam) {
        $current_streak = (int)$gam['current_streak'];
        $longest_streak = (int)$gam['longest_streak'];
        $last_date = $gam['last_activity_date'];

        if ($last_date === $today) {
            // Already active today, streak unchanged
        } elseif ($last_date === $yesterday) {
            $current_streak += 1;
        } else {
            $current_streak = 1;
        }

        if ($current_streak > $longest_streak) {
            $longest_streak = $current_streak;
        }

        $new_total_xp = (int)$gam['total_xp'] + $xp_awarded;

        $upd_gam = $db->prepare("
            UPDATE student_gamification 
            SET total_xp = ?, current_streak = ?, longest_streak = ?, last_activity_date = ? 
            WHERE id = ?
        ");
        $upd_gam->execute([$new_total_xp, $current_streak, $longest_streak, $today, $gam['id']]);
    } else {
        $current_streak = 1;
        $longest_streak = 1;
        $new_total_xp = $xp_awarded;
        $ins_gam = $db->prepare("
            INSERT INTO student_gamification (id, user_id, total_xp, current_streak, longest_streak, last_activity_date) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $ins_gam->execute([generate_uuid_v4(), $user_id, $new_total_xp, $current_streak, $longest_streak, $today]);
    }

    // 5. Calculate Chapter Progress
    $total_ch_lessons_stmt = $db->prepare("SELECT COUNT(*) FROM lessons WHERE chapter_id = ?");
    $total_ch_lessons_stmt->execute([$chapter_id]);
    $total_ch_lessons = (int)$total_ch_lessons_stmt->fetchColumn();

    $comp_ch_lessons_stmt = $db->prepare("
        SELECT COUNT(DISTINCT l.id) 
        FROM lessons l
        JOIN lesson_progress lp ON l.id = lp.lesson_id
        WHERE l.chapter_id = ? AND lp.user_id = ? AND lp.status = 'completed'
    ");
    $comp_ch_lessons_stmt->execute([$chapter_id, $user_id]);
    $comp_ch_lessons = (int)$comp_ch_lessons_stmt->fetchColumn();

    $all_regular_completed = ($total_ch_lessons > 0 && $comp_ch_lessons >= $total_ch_lessons);

    // Check if this chapter has an exam
    $ch_exam_stmt = $db->prepare("SELECT id, passing_score_percent FROM exams WHERE chapter_id = ? LIMIT 1");
    $ch_exam_stmt->execute([$chapter_id]);
    $ch_exam = $ch_exam_stmt->fetch(PDO::FETCH_ASSOC);

    $exam_passed = false;
    $exam_unlocked = $all_regular_completed;
    $has_exam = !empty($ch_exam);

    if ($has_exam) {
        $exam_pass_stmt = $db->prepare("
            SELECT MAX(score) FROM exam_attempts 
            WHERE exam_id = ? AND user_id = ? AND (passed = 1 OR score >= ?)
        ");
        $pass_thresh = (int)($ch_exam['passing_score_percent'] ?: 70);
        $exam_pass_stmt->execute([$ch_exam['id'], $user_id, $pass_thresh]);
        $best_exam_score = $exam_pass_stmt->fetchColumn();
        $exam_passed = ($best_exam_score !== false && $best_exam_score !== null);
    }

    // A chapter is completed ONLY if regular lessons are completed AND (no exam exists OR exam is passed)
    $chapter_completed = $all_regular_completed && (!$has_exam || $exam_passed);

    // Update chapter_progress
    $cp_stmt = $db->prepare("SELECT id, status FROM chapter_progress WHERE user_id = ? AND chapter_id = ?");
    $cp_stmt->execute([$user_id, $chapter_id]);
    $existing_cp = $cp_stmt->fetch();

    if ($chapter_completed) {
        if ($existing_cp) {
            $db->prepare("UPDATE chapter_progress SET status = 'completed', completed_at = IFNULL(completed_at, NOW()) WHERE id = ?")->execute([$existing_cp['id']]);
        } else {
            $db->prepare("INSERT INTO chapter_progress (id, user_id, chapter_id, status, started_at, completed_at) VALUES (?, ?, ?, 'completed', NOW(), NOW())")->execute([generate_uuid_v4(), $user_id, $chapter_id]);
        }

        // Award chapter XP if first time
        if (!$existing_cp || $existing_cp['status'] !== 'completed') {
            $ch_xp_check = $db->prepare("SELECT id FROM xp_events WHERE user_id = ? AND source_type = 'chapter' AND source_id = ?");
            $ch_xp_check->execute([$user_id, $chapter_id]);
            if (!$ch_xp_check->fetch()) {
                $ch_xp = (int)($lesson['chapter_xp'] ?? 50);
                $db->prepare("INSERT INTO xp_events (id, user_id, amount, source_type, source_id) VALUES (?, ?, ?, 'chapter', ?)")->execute([generate_uuid_v4(), $user_id, $ch_xp, $chapter_id]);
                $db->prepare("UPDATE student_gamification SET total_xp = total_xp + ? WHERE user_id = ?")->execute([$ch_xp, $user_id]);
                $xp_awarded += $ch_xp;
                $new_total_xp += $ch_xp;
            }
        }
    } else {
        if ($existing_cp) {
            if ($existing_cp['status'] !== 'completed') {
                $db->prepare("UPDATE chapter_progress SET status = 'in_progress' WHERE id = ?")->execute([$existing_cp['id']]);
            }
        } else {
            $db->prepare("INSERT INTO chapter_progress (id, user_id, chapter_id, status, started_at) VALUES (?, ?, ?, 'in_progress', NOW())")->execute([generate_uuid_v4(), $user_id, $chapter_id]);
        }
    }

    // 6. Calculate Course Progress
    $course_lessons_stmt = $db->prepare("
        SELECT COUNT(l.id) 
        FROM lessons l 
        JOIN chapters c ON l.chapter_id = c.id 
        WHERE c.course_id = ?
    ");
    $course_lessons_stmt->execute([$course_id]);
    $total_course_lessons = (int)$course_lessons_stmt->fetchColumn();

    $comp_course_lessons_stmt = $db->prepare("
        SELECT COUNT(DISTINCT l.id) 
        FROM lessons l
        JOIN chapters c ON l.chapter_id = c.id
        JOIN lesson_progress lp ON l.id = lp.lesson_id
        WHERE c.course_id = ? AND lp.user_id = ? AND lp.status = 'completed'
    ");
    $comp_course_lessons_stmt->execute([$course_id, $user_id]);
    $comp_course_lessons = (int)$comp_course_lessons_stmt->fetchColumn();

    $course_pct = $total_course_lessons > 0 ? round(($comp_course_lessons / $total_course_lessons) * 100) : 0;
    $course_completed = ($course_pct >= 100);

    $cop_stmt = $db->prepare("SELECT id FROM course_progress WHERE user_id = ? AND course_id = ?");
    $cop_stmt->execute([$user_id, $course_id]);
    $existing_cop = $cop_stmt->fetch();

    $cop_status = $course_completed ? 'completed' : 'in_progress';
    if ($existing_cop) {
        $db->prepare("UPDATE course_progress SET status = ?, completed_at = " . ($course_completed ? "IFNULL(completed_at, NOW())" : "NULL") . " WHERE id = ?")->execute([$cop_status, $existing_cop['id']]);
    } else {
        $db->prepare("INSERT INTO course_progress (id, user_id, course_id, status, started_at, completed_at) VALUES (?, ?, ?, ?, NOW(), " . ($course_completed ? "NOW()" : "NULL") . ")")->execute([generate_uuid_v4(), $user_id, $course_id, $cop_status]);
    }

    // 7. Check Achievements (e.g. First Steps)
    $total_completed_all_stmt = $db->prepare("SELECT COUNT(*) FROM lesson_progress WHERE user_id = ? AND status = 'completed'");
    $total_completed_all_stmt->execute([$user_id]);
    $total_completed_all = (int)$total_completed_all_stmt->fetchColumn();

    // Evaluate all achievement criteria (idempotent)
    try {
        $new_achs = sps_evaluate_achievements($db, $user_id);
        foreach ($new_achs as $tname) {
            $unlocked_achievements[] = $tname;
        }
    } catch (Exception $achEx) {
        error_log('Achievement eval on complete: ' . $achEx->getMessage());
    }

    // Resolve next lesson in the same course (server-authoritative navigation)
    $next_lesson = null;
    try {
        $cur_num = (int)($lesson['lesson_number'] ?? 0);
        // Next lesson in same chapter by lesson_number
        $stmt_next = $db->prepare("
            SELECT id, slug, title, lesson_number, chapter_id
            FROM lessons
            WHERE chapter_id = ? AND lesson_number > ?
            ORDER BY lesson_number ASC
            LIMIT 1
        ");
        $stmt_next->execute([$chapter_id, $cur_num]);
        $row_next = $stmt_next->fetch(PDO::FETCH_ASSOC);
        if ($row_next) {
            $next_lesson = [
                'id' => $row_next['id'],
                'slug' => $row_next['slug'],
                'title' => $row_next['title'],
                'chapter_id' => $row_next['chapter_id'],
                'course_id' => $course_id,
                'is_exam' => false,
            ];
        } elseif ($all_regular_completed && !$exam_passed) {
            // ALWAYS send student to chapter exam after last lesson (even if exam row missing — client uses chapter_id)
            $exam_id_out = !empty($ch_exam['id']) ? $ch_exam['id'] : ('exam-' . $chapter_id);
            $next_lesson = [
                'id' => $exam_id_out,
                'slug' => 'exam-' . $chapter_id,
                'title' => !empty($ch_exam['title']) ? $ch_exam['title'] : 'Chapter Exam',
                'chapter_id' => $chapter_id,
                'course_id' => $course_id,
                'is_exam' => true,
            ];
            $has_exam = true;
            $exam_unlocked = true;
        } elseif ($exam_passed || !$all_regular_completed) {
            // First lesson of next chapter only after exam passed (or no more work in chapter)
            $stmt_nch = $db->prepare("
                SELECT id FROM chapters
                WHERE course_id = ? AND chapter_number > ?
                ORDER BY chapter_number ASC
                LIMIT 1
            ");
            $ch_num = (int)($lesson['chapter_number'] ?? 0);
            $stmt_nch->execute([$course_id, $ch_num]);
            $next_ch_id = $stmt_nch->fetchColumn();
            if ($next_ch_id) {
                $stmt_nl = $db->prepare("
                    SELECT id, slug, title, lesson_number, chapter_id
                    FROM lessons
                    WHERE chapter_id = ?
                    ORDER BY lesson_number ASC
                    LIMIT 1
                ");
                $stmt_nl->execute([$next_ch_id]);
                $row_nl = $stmt_nl->fetch(PDO::FETCH_ASSOC);
                if ($row_nl) {
                    $next_lesson = [
                        'id' => $row_nl['id'],
                        'slug' => $row_nl['slug'],
                        'title' => $row_nl['title'],
                        'chapter_id' => $row_nl['chapter_id'],
                        'course_id' => $course_id,
                        'is_exam' => false,
                    ];
                }
            }
        }
    } catch (Exception $eNext) {
        error_log('Next lesson resolve: ' . $eNext->getMessage());
        $next_lesson = null;
    }

    success_response([
        'lesson_id' => $lesson_id,
        'xp_awarded' => $xp_awarded,
        'total_xp' => $new_total_xp,
        'streak' => $current_streak,
        'chapter_id' => $chapter_id,
        'course_id' => $course_id,
        'all_regular_completed' => $all_regular_completed,
        'has_exam' => $has_exam,
        'exam_id' => $has_exam ? $ch_exam['id'] : null,
        'exam_unlocked' => $exam_unlocked,
        'exam_passed' => $exam_passed,
        'chapter_completed' => $chapter_completed,
        'course_progress' => $course_pct,
        'course_completed' => $course_completed,
        'unlocked_achievements' => $unlocked_achievements,
        'next_lesson' => $next_lesson,
    ]);

} catch (Exception $e) {
    error_log('Lesson Complete Error: ' . $e->getMessage());
    error_response('Database error during lesson completion. Please try again.', 500);
}
