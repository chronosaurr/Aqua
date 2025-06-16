<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define('ROOT_PATH', __DIR__);
define('CONTROLLER_PATH', ROOT_PATH . '/controller');
define('MODEL_PATH', ROOT_PATH . '/model');
define('VIEW_PATH', ROOT_PATH . '/views');
define('CORE_PATH', ROOT_PATH . '/core');

define('SITE_NAME', 'Aqua Ticket System');
define('EMOJI', [
    'attachment' => '📎',
    'dashboard'  => '📊',
    'database'   => '📦',
    'department' => '🏢',
    'logout'     => '🚪',
    'php'        => '🐘',
    'ticket'     => '🎟️',
    'user'       => '👤',
    'users'      => '👥',
]);

define('DB_HOST', 'mariadb');             // Nazwa serwisu z docker-compose.yml
define('DB_NAME', 'system_ticketowy');    // Zgodnie z .env
define('DB_USER', 'user_ticket');         // Zgodnie z .env
define('DB_PASS', 'haslo_usera');         // Zgodnie z .env
define('DB_CHARSET', 'utf8mb4');