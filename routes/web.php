<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/store/create', function () use ($router) {
    return $router->app->version();
});

$router->post('/user/create', function () use ($router) {
    return $router->app->version();
});

$router->post('/transaction/create', function () use ($router) {
    return $router->app->version();
});
