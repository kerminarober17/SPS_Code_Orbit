<?php
require_once __DIR__ . '/auth.php';

/**
 * Admin access via secrets-based session only (not profiles.role in the database).
 */
function require_admin() {
    if (!is_admin_session()) {
        error_response('Forbidden. Admin access required.', 403);
    }
    return current_user();
}
