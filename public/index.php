<?php

session_start();

$startTime = microtime(true);

require_once '../config.php';
require_once CORE_PATH . '/Database.php';

// router

// pobranie wczesniejszego uri i wyczyszczenie
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$path = trim($path, '/');

// dzilenie URI na segmenty: controller, method, params
$segments = $path ? explode('/', $path) : [];

// domyslne wartosci
$controllerName = ucfirst($segments[0] ?? 'Dashboard') . 'Controller';
$methodName = $segments[1] ?? 'index';
$params = array_slice($segments, 2);

$controllerFile = CONTROLLER_PATH . '/' . $controllerName . '.php';


if (file_exists($controllerFile)) {
    require_once $controllerFile;
} else {
    http_response_code(404);
    require_once VIEW_PATH . '/errors/404.php';
    exit;
}


if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
    $controllerInstance = new $controllerName();
    call_user_func_array([$controllerInstance, $methodName], $params);
} else {
    http_response_code(404);
    require_once VIEW_PATH . '/errors/404.php';
    exit;
}