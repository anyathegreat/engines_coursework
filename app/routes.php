<?php
function isLoggedIn()
{
    return isset($_SESSION['user_email']);
}

function getRoutes()
{
    // Контроллер / Метод / Защищенный маршрут
    $routes = [
        // Защищённые маршруты
        '/' => ['HomeController', 'index', true],
        '/logout' => ['AuthController', 'logout', true],
        '/dashboard' => ['DashboardController', 'index', true],
        '/users' => ['UsersController', 'index', true],
        '/users/edit' => ['UsersController', 'edit', true],

        // Незащищенные маршруты
        '/catalog' => ['CatalogController', 'index', false],
        '/login' => ['AuthController', 'login', false],
    ];

    return $routes;
}

function getRoute($requestUri)
{
    $routes = getRoutes();

    return $routes[$requestUri] ?? null;
}

function getPublicRoutes()
{
    $routes = getRoutes();

    $result = [];
    foreach ($routes as $route => $data) {
        if ($data[2] === false) {
            $result[] = $route;
        }
    }

    return $result;
}

function getPrivateRoutes()
{
    $routes = getRoutes();

    $result = [];
    foreach ($routes as $route => $data) {
        if ($data[2] === true) {
            $result[] = $route;
        }
    }

    return $result;
}

