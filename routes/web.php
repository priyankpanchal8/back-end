<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/logout', 'AuthController@logout');

        $router->get('/{userID}', 'UserController@index');
        $router->get('/userDetails/{userID}', 'UserController@userDetails');
        $router->put('/editUser/{userID}', 'UserController@editUser');

        $router->get('/{userID}', 'UserController@index');
        $router->post('/connect', 'UserConnectionController@Connect');
        $router->post('/disconnect', 'UserConnectionController@disConnect');

        $router->get('/schedule/{userID}', 'ScheduleController@index');
        $router->post('/schedule', 'ScheduleController@createSchedule');
        $router->put('/schedule/{id}', 'ScheduleController@updateSchedule');
        $router->delete('/schedule/{id}', 'ScheduleController@removeSchedule');
    });
});
