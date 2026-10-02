<?php
/**
 * TEMPORARY — InfinityFree / shared hosting without SSH
 * Browser entry point for: database/seed_exams.php
 *
 * Does NOT reimplement seeding. Includes the official CLI seeder.
 *
 * Setup:
 *   1. Set SEED_WEB_TOKEN in config/secrets.local.php (same token as curriculum runner).
 *   2. Run curriculum seed first (seed_curriculum_web.php).
 *   3. Open: /seed_exams_web.php?key=YOUR_TOKEN
 *   4. Confirm SUCCESS (37 chapter exams).
 *   5. DELETE this file from the server immediately after success.
 *
 * School servers with SSH should use: php database/seed_exams.php
 */
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

function sps_exam_seed_web_html_start(string $title): void
{
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title></head>';
    echo '<body style="font-family:ui-monospace,Consolas,monospace;background:#070A14;color:#e2e8f0;padding:1.5rem;line-height:1.45;">';
}

function sps_exam_seed_web_forbidden(string $hint = ''): void
{
    http_response_code(403);
    sps_exam_seed_web_html_start('403 Forbidden');
    echo '<h2 style="color:#f87171;">403 Forbidden</h2>';
    echo '<p>This temporary seeder requires a valid <code>SEED_WEB_TOKEN</code>.</p>';
    echo '<ol style="color:#94a3b8;">';
    echo '<li>Set <code>SEED_WEB_TOKEN</code> in <code>config/secrets.local.php</code>.</li>';
    echo '<li>Open: <code>seed_exams_web.php?key=YOUR_TOKEN</code></li>';
    echo '<li>Delete this PHP file after seeding.</li>';
    echo '</ol>';
    if ($hint !== '') {
        echo '<p style="color:#fbbf24;">' . htmlspecialchars($hint, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '</body></html>';
    exit;
}

try {
    require_once __DIR__ . '/config/config.php';
} catch (Throwable $e) {
    sps_exam_seed_web_html_start('Config error');
    echo '<h2 style="color:#f87171;">Configuration error</h2>';
    echo '<p>Could not load config. Ensure <code>config/config.php</code> is uploaded.</p>';
    echo '</body></html>';
    exit;
}

$expected = (string) sps_config_value('SEED_WEB_TOKEN', '');
$provided = isset($_GET['key']) ? (string) $_GET['key'] : '';

if ($expected === '' || $expected === 'CHANGE_ME_TO_LONG_RANDOM_STRING') {
    sps_exam_seed_web_forbidden('SEED_WEB_TOKEN is not set (or still the placeholder). Set it in config/secrets.local.php.');
}

if ($provided === '' || !hash_equals($expected, $provided)) {
    sps_exam_seed_web_forbidden();
}

sps_exam_seed_web_html_start('SPS Code Orbit — Exam Seed');
echo '<h2 style="color:#38bdf8;">SPS Code Orbit — Exam Seed (temporary web runner)</h2>';
echo '<p style="color:#94a3b8;">Invoking official seeder: <code>database/seed_exams.php</code></p>';
echo '<p style="color:#fbbf24;">Requires curriculum seed first (37 chapters must exist).</p>';
echo '<pre style="background:#0f172a;padding:1.25rem;border-radius:12px;border:1px solid #334155;white-space:pre-wrap;word-break:break-word;">';

$seedFile = __DIR__ . '/database/seed_exams.php';
$status = 'UNKNOWN';
$out = '';

ob_start();
try {
    if (!is_readable($seedFile)) {
        throw new RuntimeException('File not found or not readable: database/seed_exams.php — upload the full project.');
    }
    include $seedFile;
    $out = (string) ob_get_clean();
    if (stripos($out, 'Exam seed complete') !== false) {
        $status = 'SUCCESS';
    } elseif (
        stripos($out, 'Exam seed error:') !== false
        || stripos($out, 'Refusing') !== false
        || stripos($out, 'ERROR:') !== false
        || stripos($out, 'seed_curriculum') !== false && stripos($out, 'first') !== false
    ) {
        $status = 'FAILED';
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

if ($status === 'SUCCESS') {
    echo '<p style="color:#34d399;font-weight:700;">STATUS: SUCCESS</p>';
    echo '<p>Expected: <strong>37</strong> chapter exams linked to official course chapters.</p>';
} elseif ($status === 'COMPLETED_WITH_OUTPUT') {
    echo '<p style="color:#fbbf24;font-weight:700;">STATUS: COMPLETED_WITH_OUTPUT — read the log above carefully.</p>';
} else {
    echo '<p style="color:#f87171;font-weight:700;">STATUS: FAILED</p>';
    echo '<p>Common causes: curriculum not seeded yet, missing <code>data/production_exams.json</code>, DB credentials, or chapter count ≠ 37.</p>';
}

echo '<p style="color:#f87171;font-weight:800;margin-top:1.5rem;">DELETE <code>seed_exams_web.php</code> from the server after a successful run.</p>';
echo '<p><a href="/student/courses.html" style="color:#38bdf8;">Open student courses</a></p>';
echo '</body></html>';
