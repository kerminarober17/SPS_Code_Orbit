<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../middleware/admin.php';
require_once __DIR__ . '/../../middleware/csrf.php';

require_post_method();
$user = require_admin();
verify_csrf_token();

$data = get_json_request();
$id = trim($data['id'] ?? '');
if ($id === '') {
    error_response('Challenge id is required', 400);
}

try {
    $db = get_db_connection();
    $stmt = $db->prepare("SELECT id FROM challenges WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        error_response('Challenge not found', 404);
    }

    $fields = [];
    $params = [];
    $map = [
        'title' => 'title',
        'description' => 'description',
        'instructions' => 'instructions',
        'difficulty' => 'difficulty',
        'course_id' => 'course_id',
        'class_id' => 'class_id',
        'academic_group_id' => 'academic_group_id',
        'target_audience' => 'target_audience',
        'allowed_types' => 'allowed_types',
        'deadline' => 'deadline',
        'xp_reward' => 'xp_reward',
    ];

    foreach ($map as $key => $col) {
        if (array_key_exists($key, $data)) {
            $val = $data[$key];
            if (in_array($key, ['course_id', 'class_id', 'academic_group_id', 'deadline'], true) && ($val === '' || $val === null)) {
                $val = null;
            }
            if ($key === 'xp_reward') {
                $val = max(0, (int)$val);
            }
            $fields[] = "$col = ?";
            $params[] = $val;
        }
    }

    if (array_key_exists('is_published', $data)) {
        $fields[] = "is_published = ?";
        $params[] = !empty($data['is_published']) ? 1 : 0;
    }
    if (array_key_exists('is_archived', $data)) {
        $fields[] = "is_archived = ?";
        $params[] = !empty($data['is_archived']) ? 1 : 0;
    }

    if (empty($fields)) {
        error_response('No fields to update', 400);
    }

    $params[] = $id;
    $sql = "UPDATE challenges SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = ?";
    $db->prepare($sql)->execute($params);

    success_response(['id' => $id, 'message' => 'Challenge updated']);
} catch (Exception $e) {
    error_log('Challenge update error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
