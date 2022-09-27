<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->group(['prefix' => 'auth'], function () use ($router) {
            $router->post('/', 'AuthController@create');
        });

        $router->post('/user', 'UserController@create');

        $router->group(['prefix' => 'ponto', 'middleware' => 'auth'], function () use ($router) {
            $router->post('/', 'PontoController@create');
        });
    });
});
