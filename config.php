<?php

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$appEnv = $_ENV['APP_ENV'] ?? 'production';

if ($appEnv === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
    // ini_set('log_errors', 1);
    // ini_set('error_log', ROOT_PATH . '/logs/php_errors.log');
}


define('ROOT_PATH', __DIR__);
define('CONTROLLER_PATH', ROOT_PATH . '/controller');
define('MODEL_PATH', ROOT_PATH . '/model');
define('VIEW_PATH', ROOT_PATH . '/views');
define('CORE_PATH', ROOT_PATH . '/core');


define('SITE_NAME', 'Aqua Ticket System');
define('EMOJI', [
    'attachment' => '📎',
    'clock'      => '⏰',
    'dashboard'  => '📊',
    'database'   => '📦',
    'department' => '🏢',
    'logout'     => '🚪',
    'memory'     => '💾',
    'php'        => '🐘',
    'ticket'     => '🎟️',
    'user'       => '👤',
    'users'      => '👥',
]);


define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_CHARSET', $_ENV['DB_CHARSET']);