<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\GraphQL as GraphQLController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->post('/graphql', [GraphQLController::class, 'handle']);
    $r->addRoute('OPTIONS', '/graphql', [GraphQLController::class, 'handle']);
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed', 'allowed' => $allowedMethods]);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $entityManager = require_once __DIR__ . '/../bootstrap.php';
        $controller = new $handler[0]($entityManager);
        echo $controller->{$handler[1]}($vars);
        break;
}
