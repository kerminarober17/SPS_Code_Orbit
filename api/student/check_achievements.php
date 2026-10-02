<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/achievements_helpers.php';
require_once __DIR__ . '/../../middleware/student.php';

require_post_method();
$user = require_student();
// CSRF optional for internal progress refresh; require if token present
if (!empty($_SERVER['HTTP_X_CSRF_TOKEN']) || !empty($_POST['csrf_token'])) {
    require_once __DIR__ . '/../../middleware/csrf.php';
    verify_csrf_token();
}

try {
    $db = get_db_connection();
    $newly = sps_evaluate_achievements($db, $user['id']);
    success_response(['newly_awarded' => $newly, 'checked' => true]);
} catch (Exception $e) {
    error_log('check_achievements: ' . $e->getMessage());
    error_response('Failed to evaluate achievements', 500);
}
