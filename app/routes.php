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
        '/' => ['HomeController', 'index', ["anonymous"]],
        '/logout' => ['AuthController', 'logout', []],
        '/dashboard' => ['DashboardController', 'index', []],
        '/users' => ['UsersController', 'index', ["admin"]],
        '/users/edit' => ['UsersController', 'edit', ["admin"]],
        '/users/create' => ['UsersController', 'create', ["admin"]],
        '/users/delete' => ['UsersController', 'delete', ["admin"]],
        '/products' => ['ProductsController', 'index', ["admin"]],
        '/products/edit' => ['ProductsController', 'edit', ["admin"]],
        '/products/create' => ['ProductsController', 'create', ["admin"]],
        '/products/delete' => ['ProductsController', 'delete', ["admin"]],
        '/orders' => ['OrdersController', 'index', ["user", "admin"]],
        '/order' => ['OrderController', 'index', ["user", "admin"]],
        '/order/delete' => ['OrderController', 'delete', ["admin"]],
        '/order/edit' => ['OrderController', 'edit', ["user", "admin"]],
        '/order/edit/products' => ['OrderController', 'editProducts', ["user", "admin"]],

        // Незащищенные маршруты
        '/catalog' => ['CatalogController', 'index', ["anonymous"]],
        '/login' => ['AuthController', 'login', ["anonymous"]],
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
        if (in_array("anonymous", $data[2])) {
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
        if (empty($data[2]) || in_array("anonymous", $data[2]) || (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], $data[2]))) {
            $result[] = $route;
        }
    }

    return $result;
}

