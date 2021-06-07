<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/** @see TransactionController::performTransaction() */
$router->post('transaction', TransactionController::class . '@performTransaction');
