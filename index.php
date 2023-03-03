<?php

use \Test\Controllers\MainController;
use \Test\Controllers\UsersController;
use \Test\Database\Db;

spl_autoload_register(function (string $className) 
{
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
});

$route = $_GET['route'] ?? '';
$routes = require __DIR__ . '/src/Test/Config/routes.php';

$isRouteFound = false;
foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    $view = new \Test\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('404.php');
}
else{
$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();
$controller->$actionName();
}

