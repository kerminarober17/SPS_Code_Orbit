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
$title = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$instructions = trim($data['instructions'] ?? '');
$difficulty = trim($data['difficulty'] ?? 'medium');
$course_id = !empty($data['course_id']) ? trim($data['course_id']) : null;
$class_id = !empty($data['class_id']) ? trim($data['class_id']) : null;
$academic_group_id = !empty($data['academic_group_id']) ? trim($data['academic_group_id']) : null;
$target_audience = trim($data['target_audience'] ?? 'all');
$allowed_types = trim($data['allowed_types'] ?? 'zip,image');
$deadline = !empty($data['deadline']) ? trim($data['deadline']) : null;
$is_published = !empty($data['is_published']) ? 1 : 0;
$xp_reward = isset($data['xp_reward']) ? max(0, (int)$data['xp_reward']) : 0;

if ($title === '' || $instructions === '') {
    error_response('Title and instructions are required', 400);
}

$allowedDiff = ['easy', 'medium', 'hard'];
if (!in_array($difficulty, $allowedDiff, true)) {
    $difficulty = 'medium';
}
$allowedAudience = ['all', 'course', 'class', 'academic_group'];
if (!in_array($target_audience, $allowedAudience, true)) {
    $target_audience = 'all';
}

try {
    $db = get_db_connection();
    $id = generate_uuid_v4();
    $stmt = $db->prepare("
        INSERT INTO challenges (
            id, title, description, instructions, difficulty,
            course_id, class_id, academic_group_id, target_audience,
            allowed_types, deadline, is_published, xp_reward, created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $id, $title, $description, $instructions, $difficulty,
        $course_id, $class_id, $academic_group_id, $target_audience,
        $allowed_types, $deadline, $is_published, $xp_reward, $user['id']
    ]);

    success_response(['id' => $id, 'message' => 'Challenge created'], 201);
} catch (Exception $e) {
    error_log('Challenge create error: ' . $e->getMessage());
    error_response('Server error. Please try again.', 500);
}
