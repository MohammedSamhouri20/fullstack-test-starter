<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\GraphQL as GraphQLController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->post('/graphql', [GraphQLController::class, 'handle']);
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1]; // [GraphQLController::class, 'handle']
        $vars = $routeInfo[2];

        // Get EntityManager (assumes you have a bootstrapped Doctrine setup)
        $entityManager = require_once __DIR__ . '/../bootstrap.php';
        // Instantiate GraphQLController and call handle()
        $controller = new $handler[0]($entityManager);
        echo $controller->{$handler[1]}($vars);

        break;
}
