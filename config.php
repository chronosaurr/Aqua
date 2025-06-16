<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define('ROOT_PATH', __DIR__);
define('CONTROLLER_PATH', ROOT_PATH . '/controller');
define('VIEW_PATH', ROOT_PATH . '/views');


define('SITE_NAME', 'Aqua Ticket System');

// Centralna definicja emoji!
define('EMOJI', [
    'ticket'     => '🎟️',
    'user'       => '👤',
    'department' => '🏢',
    'attachment' => '📎',
    'dashboard'  => '📊',
    'logout'     => '🚪'
]);