<?php
/**
 * PDO database connection for SPS Code Orbit.
 * Credentials come from config/config.php (and optional config/secrets.local.php).
 */
require_once __DIR__ . '/config.php';

function get_db_connection(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = DB_HOST;
    $port = DB_PORT;
    $db   = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASSWORD;
    $charset = DB_CHARSET;

    if ($host === '' || $db === '' || $user === '') {
        error_log('SPS DB config incomplete: DB_HOST/DB_NAME/DB_USER must be set in config.php or config/secrets.local.php');
        throw new \Exception('Database configuration error.');
    }

    if ($pass === '' && defined('APP_ENV') && APP_ENV === 'production') {
        error_log('SPS DB config: DB_PASSWORD is empty in production. Set DB_PASSWORD in config/secrets.local.php');
        throw new \Exception('Database configuration error.');
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $socket = getenv('DB_SOCKET') ?: '';
    if ($socket !== '' && file_exists($socket)) {
        $dsn = "mysql:unix_socket={$socket};dbname={$db};charset={$charset}";
    } else {
        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";
    }

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (\PDOException $e) {
        $code = $e->getCode();
        $msg  = $e->getMessage();
        error_log('SPS DB connection failed: ' . $msg . ' | host=' . $host . ' db=' . $db . ' user=' . $user);

        if (defined('APP_ENV') && APP_ENV === 'development') {
            throw new \PDOException($msg, (int) $code);
        }
        throw new \Exception('Database connection error.');
    }
}
