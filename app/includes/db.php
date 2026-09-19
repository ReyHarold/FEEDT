<?php
require_once __DIR__ . '/../config.php';

/**
 * Shared PDO connection. Throws on error, returns associative arrays by default.
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        exit('<h2 style="font-family:sans-serif;color:#b91c1c">Database connection failed.</h2>'
            . '<p style="font-family:sans-serif">Start MySQL and import <code>app/schema.sql</code>, '
            . 'then check credentials in <code>app/config.php</code>.</p>');
    }
    return $pdo;
}
