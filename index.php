<?php
require_once 'config.php'; // Подключаем файл базы данных
require_once 'app/database.php'; // Подключаем файл базы данных
require_once 'app/routes.php'; // Подключаем маршруты

if (!isset($_SESSION)) {
    session_start();
}

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Проверка авторизации
if (!isLoggedIn() && !in_array($requestUri, getPublicRoutes())) {
    header('Location: /login');
    exit;
}

$route = getRoute($requestUri);

if (!$route) {
    http_response_code(404);
    require_once 'app/views/error.php';

    exit;
}

list($controllerName, $methodName) = $route;

// Подключаем нужный контроллер
require_once 'app/controllers/' . $controllerName . '.php';

// Передаем объект mysqli в контроллер
$controller = new $controllerName($mysqli); // Передаем модель в контроллер

require_once 'app/views/layout.php';