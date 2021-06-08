<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'transaction'], function () use ($router) {
    /** @see TransactionController::performTransaction() */
    $router->post('create', TransactionController::class . '@performTransaction');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    /** @see UserController::createUser() */
    $router->post('create', UserController::class . '@createUser');
});

$router->group(['prefix' => 'store'], function () use ($router) {
    /** @see StoreController::createStore() */
    $router->post('create', StoreController::class . '@createStore');
});

