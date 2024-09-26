<?php
require_once 'config.php'; // Подключаем файл базы данных
require_once 'app/database.php'; // Подключаем файл базы данных
require_once 'app/routes.php'; // Подключаем маршруты

if (!isset($_SESSION)) {
    session_start();
}

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = getRoute($requestUri);

if (!$route) {
    http_response_code(404);
    require_once 'app/views/error.php';

    exit;
}

if (isLoggedIn()) {
    if (!(empty($route[2]) || in_array("anonymous", $route[2]) || (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], $route[2])))) {
        header("Location: /");
        exit;
    }
} else {
    if (!in_array("anonymous", $route[2])) {
        header("Location: /");
        exit;
    }
}



list($controllerName, $methodName) = $route;

// Подключаем нужный контроллер
require_once 'app/controllers/' . $controllerName . '.php';

// Передаем объект mysqli в контроллер
$controller = new $controllerName($mysqli); // Передаем модель в контроллер

require_once 'app/views/layout.php';