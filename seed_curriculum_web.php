<?php
/**
 * TEMPORARY — InfinityFree / shared hosting without SSH
 * Browser entry point for: database/seed_curriculum.php
 *
 * Does NOT reimplement seeding. Includes the official CLI seeder.
 *
 * Setup:
 *   1. Set SEED_WEB_TOKEN in config/secrets.local.php (long random string).
 *   2. Open: /seed_curriculum_web.php?key=YOUR_TOKEN
 *   3. Confirm SUCCESS and counts (5 courses / 37 chapters / 155 lessons).
 *   4. DELETE this file from the server immediately after success.
 *
 * School servers with SSH should use: php database/seed_curriculum.php
 */
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

function sps_seed_web_html_start(string $title): void
{
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title></head>';
    echo '<body style="font-family:ui-monospace,Consolas,monospace;background:#070A14;color:#e2e8f0;padding:1.5rem;line-height:1.45;">';
}

function sps_seed_web_forbidden(string $hint = ''): void
{
    http_response_code(403);
    sps_seed_web_html_start('403 Forbidden');
    echo '<h2 style="color:#f87171;">403 Forbidden</h2>';
    echo '<p>This temporary seeder requires a valid <code>SEED_WEB_TOKEN</code>.</p>';
    echo '<ol style="color:#94a3b8;">';
    echo '<li>Copy <code>config/secrets.local.php.example</code> to <code>config/secrets.local.php</code> if needed.</li>';
    echo '<li>Set a long random <code>SEED_WEB_TOKEN</code> in <code>$SPS_SECRETS</code>.</li>';
    echo '<li>Open: <code>seed_curriculum_web.php?key=YOUR_TOKEN</code></li>';
    echo '<li>Delete this PHP file from the server after seeding.</li>';
    echo '</ol>';
    if ($hint !== '') {
        echo '<p style="color:#fbbf24;">' . htmlspecialchars($hint, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '</body></html>';
    exit;
}

// Load secrets the same way as the rest of the app (no hardcoded DB credentials)
try {
    require_once __DIR__ . '/config/config.php';
} catch (Throwable $e) {
    sps_seed_web_html_start('Config error');
    echo '<h2 style="color:#f87171;">Configuration error</h2>';
    echo '<p>Could not load config. Ensure <code>config/config.php</code> is uploaded.</p>';
    echo '</body></html>';
    exit;
}

$expected = (string) sps_config_value('SEED_WEB_TOKEN', '');
$provided = isset($_GET['key']) ? (string) $_GET['key'] : '';

if ($expected === '' || $expected === 'CHANGE_ME_TO_LONG_RANDOM_STRING') {
    sps_seed_web_forbidden('SEED_WEB_TOKEN is not set (or still the placeholder). Set it in config/secrets.local.php.');
}

if ($provided === '' || !hash_equals($expected, $provided)) {
    sps_seed_web_forbidden();
}

sps_seed_web_html_start('SPS Code Orbit — Curriculum Seed');
echo '<h2 style="color:#38bdf8;">SPS Code Orbit — Curriculum Seed (temporary web runner)</h2>';
echo '<p style="color:#94a3b8;">Invoking official seeder: <code>database/seed_curriculum.php</code></p>';
echo '<pre style="background:#0f172a;padding:1.25rem;border-radius:12px;border:1px solid #334155;white-space:pre-wrap;word-break:break-word;">';

$seedFile = __DIR__ . '/database/seed_curriculum.php';
$status = 'UNKNOWN';
$out = '';

ob_start();
try {
    if (!is_readable($seedFile)) {
        throw new RuntimeException('File not found or not readable: database/seed_curriculum.php — upload the full project.');
    }
    include $seedFile;
    $out = (string) ob_get_clean();
    if (stripos($out, 'VALIDATION FAILED') !== false
        || stripos($out, 'Error during curriculum') !== false
        || stripos($out, 'POST-SEED VERIFICATION FAILED') !== false
    ) {
        $status = 'FAILED';
    } elseif (stripos($out, 'Curriculum sync completed successfully') !== false
        || stripos($out, 'Courses seeded:') !== false
    ) {
        $status = 'SUCCESS';
    } else {
        $status = 'COMPLETED_WITH_OUTPUT';
    }
} catch (Throwable $e) {
    $buf = (string) ob_get_clean();
    $out = $buf . "\nERROR: " . $e->getMessage();
    $status = 'FAILED';
}

echo htmlspecialchars($out, ENT_QUOTES, 'UTF-8');
echo '</pre>';

if ($status === 'SUCCESS' || $status === 'COMPLETED_WITH_OUTPUT') {
    echo '<p style="color:#34d399;font-weight:700;">STATUS: ' . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>Expected: <strong>5 courses</strong>, <strong>37 chapters</strong>, <strong>155 lessons</strong> (all published).</p>';
    echo '<p>Next: run <code>seed_exams_web.php?key=YOUR_TOKEN</code> (same SEED_WEB_TOKEN).</p>';
} else {
    echo '<p style="color:#f87171;font-weight:700;">STATUS: FAILED</p>';
    echo '<p>Fix the error above (DB credentials, MASTER_DATABASE import, missing curriculum_export.json) and retry.</p>';
}

echo '<p style="color:#f87171;font-weight:800;margin-top:1.5rem;">DELETE <code>seed_curriculum_web.php</code> from the server after a successful run.</p>';
echo '<p style="color:#64748b;">Seeder is idempotent (upsert). Re-running is safe but keep this file private and temporary.</p>';
echo '</body></html>';
