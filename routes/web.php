<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'transaction'], function () use ($router) {
    /** @see TransactionController::performTransaction() */
    $router->post('create', TransactionController::class . '@performTransaction');
    /** @see TransactionController::listTransactions() */
    $router->get('list', TransactionController::class . '@listTransactions');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    /** @see UserController::createUser() */
    $router->post('create', UserController::class . '@createUser');
    /** @see UserController::listUsers() */
    $router->get('list', UserController::class . '@listUsers');
});

$router->group(['prefix' => 'store'], function () use ($router) {
    /** @see StoreController::createStore() */
    $router->post('create', StoreController::class . '@createStore');
    /** @see StoreController::listStores() */
    $router->get('list', StoreController::class . '@listStores');
});

