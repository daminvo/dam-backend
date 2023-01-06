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
    echo "<center> Welcome </center>";
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

Route::group([

    'prefix' => 'api'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    Route::post('userProfile', 'AuthController@me');
    Route::post('googleSign', 'AuthController@googleSign');
    Route::post('CreateViva', 'UserController@CreateViva');
    Route::post('getVivaInfo', 'UserController@getVivaInfo');

});

// $router->group([ 'prefix' => 'api'], function () use ($router) {
//     Route::get('/index', 'UserController@index');
//     Route::post('/createUser', 'UserController@create');
// });

// Route::get('/index', [UserController::class, 'index']);
