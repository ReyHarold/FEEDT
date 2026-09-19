<?php
/**
 * FeedTrack — application configuration.
 * Defaults target a standard XAMPP MySQL. Any value can be overridden with an
 * environment variable of the same name (handy for testing/deployment).
 */

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'feedtrack');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');

define('APP_NAME', 'FeedTrack');

// Base URL path where the app is served (e.g. "/FEEDT/app"). Auto-detected.
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'));

date_default_timezone_set('Asia/Manila');
