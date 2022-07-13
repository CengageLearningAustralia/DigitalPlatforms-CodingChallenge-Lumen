<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded in bootstrap/app.php
|
|
*/

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->group(['prefix' => 'sessions'], function () use ($router) {
        $router->get('index', 'SessionController@index');
        //TODO: verify why {session:id} param parsing not working
        $router->get('{sessionId}/show', 'SessionController@show');
        $router->post('create', 'SessionController@store');
        $router->put('{sessionId}/assign/{bookId}', 'SessionController@assignBook');
    });
    $router->group(['prefix' => 'books'], function () use ($router) {
        $router->post('create', 'SessionController@store');
        //TODO: verify why {session:id} param parsing not working
        $router->get('{sessionId}/show', 'SessionController@show');
        $router->get('index', 'SessionController@index');
    });
});
