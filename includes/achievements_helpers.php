<?php
/**
 * Evaluate achievement criteria and award any newly earned badges.
 * Idempotent: student_achievements UNIQUE (user_id, achievement_id) + INSERT IGNORE.
 * Does not throw on missing tables; returns list of newly awarded achievement titles.
 */
function sps_evaluate_achievements(PDO $db, string $user_id): array
{
    $newly_titles = [];
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM lesson_progress WHERE user_id = ? AND status = 'completed'");
        $stmt->execute([$user_id]);
        $lessons = (int)$stmt->fetchColumn();

        $exams = 0;
        try {
            $stmt = $db->prepare("SELECT COUNT(DISTINCT exam_id) FROM exam_attempts WHERE user_id = ? AND (passed = 1 OR score >= 60)");
            $stmt->execute([$user_id]);
            $exams = (int)$stmt->fetchColumn();
        } catch (Exception $e) {}

        $challenges_sub = 0;
        $challenges_acc = 0;
        try {
            $stmt = $db->prepare("SELECT COUNT(*) FROM challenge_submissions WHERE user_id = ? AND is_active = 1");
            $stmt->execute([$user_id]);
            $challenges_sub = (int)$stmt->fetchColumn();
            $stmt = $db->prepare("SELECT COUNT(*) FROM challenge_submissions WHERE user_id = ? AND is_active = 1 AND status IN ('accepted','approved','passed')");
            $stmt->execute([$user_id]);
            $challenges_acc = (int)$stmt->fetchColumn();
        } catch (Exception $e) {}

        $gam = $db->prepare("SELECT total_xp, current_streak FROM student_gamification WHERE user_id = ?");
        $gam->execute([$user_id]);
        $g = $gam->fetch(PDO::FETCH_ASSOC) ?: ['total_xp' => 0, 'current_streak' => 0];
        $xp = (int)$g['total_xp'];
        $streak = (int)$g['current_streak'];

        $achievements = $db->query("SELECT id, title, criteria_json, xp_reward FROM achievements")->fetchAll(PDO::FETCH_ASSOC);
        if (!$achievements) {
            return [];
        }

        $earned = [];
        $stmtE = $db->prepare("SELECT achievement_id FROM student_achievements WHERE user_id = ?");
        $stmtE->execute([$user_id]);
        foreach ($stmtE->fetchAll(PDO::FETCH_COLUMN) as $aid) {
            $earned[$aid] = true;
        }

        $ins = $db->prepare("INSERT IGNORE INTO student_achievements (id, user_id, achievement_id, earned_at) VALUES (?, ?, ?, NOW())");

        foreach ($achievements as $ach) {
            if (isset($earned[$ach['id']])) {
                continue;
            }
            $crit = json_decode($ach['criteria_json'] ?? '{}', true) ?: [];
            $type = $crit['type'] ?? '';
            $need = (int)($crit['count'] ?? 0);
            $ok = false;
            if ($type === 'lessons_completed' && $lessons >= $need) {
                $ok = true;
            } elseif ($type === 'exams_passed' && $exams >= $need) {
                $ok = true;
            } elseif ($type === 'challenges_submitted' && $challenges_sub >= $need) {
                $ok = true;
            } elseif ($type === 'challenges_accepted' && $challenges_acc >= $need) {
                $ok = true;
            } elseif ($type === 'streak' && $streak >= $need) {
                $ok = true;
            } elseif ($type === 'total_xp' && $xp >= $need) {
                $ok = true;
            }
            if (!$ok) {
                continue;
            }
            $rowId = function_exists('generate_uuid_v4') ? generate_uuid_v4() : bin2hex(random_bytes(16));
            $ins->execute([$rowId, $user_id, $ach['id']]);
            if ($ins->rowCount() > 0) {
                $newly_titles[] = $ach['title'] ?? $ach['id'];
                $reward = (int)($ach['xp_reward'] ?? 0);
                if ($reward > 0) {
                    try {
                        $db->prepare("UPDATE student_gamification SET total_xp = total_xp + ? WHERE user_id = ?")->execute([$reward, $user_id]);
                        if (function_exists('generate_uuid_v4')) {
                            $db->prepare("INSERT INTO xp_events (id, user_id, amount, source_type, source_id) VALUES (?, ?, ?, 'achievement', ?)")
                                ->execute([generate_uuid_v4(), $user_id, $reward, $ach['id']]);
                        }
                    } catch (Exception $e) {}
                }
            }
        }
    } catch (Exception $e) {
        error_log('sps_evaluate_achievements: ' . $e->getMessage());
    }
    return $newly_titles;
}
