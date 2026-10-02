<?php
/**
 * SPS Code Orbit — server-side configuration
 *
 * Secrets (DB password, OpenRouter API key) must NEVER be committed with real values.
 * Place production secrets in:
 *   config/secrets.local.php
 * (copy from secrets.local.php.example). That file is server-only and blocked by config/.htaccess.
 *
 * No .env file is required. Optional environment variables override secrets.local.php values
 * via sps_config_value() when set.
 *
 * Official install: see INSTALL.txt
 */

// Non-secret defaults only. Leave credentials EMPTY so misconfigured deploys fail closed.
$DB_HOST_DEFAULT     = '';
$DB_PORT_DEFAULT     = '3306';
$DB_NAME_DEFAULT     = '';
$DB_USER_DEFAULT     = '';
$DB_PASSWORD_DEFAULT = '';
$DB_CHARSET_DEFAULT  = 'utf8mb4';

$APP_NAME_DEFAULT         = 'SPS Code Orbit';
$APP_ENV_DEFAULT          = 'production';
$SESSION_NAME_DEFAULT     = 'sps_session';
$SESSION_LIFETIME_DEFAULT = 86400;

// Cody is optional. Empty key = Cody disabled / graceful failure (no secret in repo).
$CODY_OPENROUTER_API_KEY_DEFAULT    = '';
$CODY_PRIMARY_MODEL_DEFAULT         = 'nvidia/nemotron-3-ultra-550b-a55b:free';
$CODY_FALLBACK_MODEL_DEFAULT        = '';
$CODY_MAX_TOKENS_DEFAULT            = '1024';
$CODY_TIMEOUT_SECONDS_DEFAULT       = '45';
$CODY_RATE_LIMIT_PER_MINUTE_DEFAULT = '20';
$CODY_ENABLED_DEFAULT               = '1';

$SPS_SECRETS = [];
$secretsLocal = __DIR__ . '/secrets.local.php';
if (is_file($secretsLocal)) {
    require $secretsLocal;
    if (!isset($SPS_SECRETS) || !is_array($SPS_SECRETS)) {
        $SPS_SECRETS = [];
    }
}

function sps_config_value(string $key, $default) {
    global $SPS_SECRETS;
    if (isset($SPS_SECRETS[$key]) && $SPS_SECRETS[$key] !== '' && $SPS_SECRETS[$key] !== null) {
        return $SPS_SECRETS[$key];
    }
    $v = getenv($key);
    if ($v !== false && $v !== '') {
        return $v;
    }
    return $default;
}

define('DB_HOST', (string) sps_config_value('DB_HOST', $DB_HOST_DEFAULT));
define('DB_PORT', (string) sps_config_value('DB_PORT', $DB_PORT_DEFAULT));
define('DB_NAME', (string) sps_config_value('DB_NAME', $DB_NAME_DEFAULT));
define('DB_USER', (string) sps_config_value('DB_USER', $DB_USER_DEFAULT));
define('DB_PASSWORD', (string) sps_config_value('DB_PASSWORD', $DB_PASSWORD_DEFAULT));
define('DB_CHARSET', (string) sps_config_value('DB_CHARSET', $DB_CHARSET_DEFAULT));

define('APP_NAME', (string) sps_config_value('APP_NAME', $APP_NAME_DEFAULT));
define('APP_ENV', (string) sps_config_value('APP_ENV', $APP_ENV_DEFAULT));
define('SESSION_NAME', (string) sps_config_value('SESSION_NAME', $SESSION_NAME_DEFAULT));
define('SESSION_LIFETIME', (int) sps_config_value('SESSION_LIFETIME', (string) $SESSION_LIFETIME_DEFAULT));

define('CODY_OPENROUTER_API_KEY', (string) sps_config_value('CODY_OPENROUTER_API_KEY', $CODY_OPENROUTER_API_KEY_DEFAULT));
define('CODY_PRIMARY_MODEL', (string) sps_config_value('CODY_PRIMARY_MODEL', $CODY_PRIMARY_MODEL_DEFAULT));
define('CODY_FALLBACK_MODEL', (string) sps_config_value('CODY_FALLBACK_MODEL', $CODY_FALLBACK_MODEL_DEFAULT));
define('CODY_MAX_TOKENS', (int) sps_config_value('CODY_MAX_TOKENS', $CODY_MAX_TOKENS_DEFAULT));
define('CODY_TIMEOUT_SECONDS', (int) sps_config_value('CODY_TIMEOUT_SECONDS', $CODY_TIMEOUT_SECONDS_DEFAULT));
define('CODY_RATE_LIMIT_PER_MINUTE', (int) sps_config_value('CODY_RATE_LIMIT_PER_MINUTE', $CODY_RATE_LIMIT_PER_MINUTE_DEFAULT));
$_cody_en = (string) sps_config_value('CODY_ENABLED', $CODY_ENABLED_DEFAULT);
define('CODY_ENABLED', $_cody_en === '1' || $_cody_en === 'true');
define('CODY_OPENROUTER_URL', 'https://openrouter.ai/api/v1/chat/completions');
