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

/**
 * API routes
 * Here you can register all API routes with the prefix api
 */
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('category', ['uses' => 'CategoryController@create']);

    // Books Endpoints --- start
    $router->get('books',  ['uses' => 'BookController@index']);

    $router->get('books/{id}', ['uses' => 'BookController@show']);

    $router->post('books', ['uses' => 'BookController@store']);

    $router->put('books/{id}', ['uses' => 'BookController@update']);

    $router->delete('books/{id}', ['uses' => 'BookController@delete']);

    // Books Endpoints --- start
    
    // Equipments Endpoints --- start
    $router->get('equipments',  ['uses' => 'EquipmentController@index']);

    $router->get('equipments/{id}', ['uses' => 'EquipmentController@show']);

    $router->post('equipments', ['uses' => 'EquipmentController@store']);

    $router->put('equipments/{id}', ['uses' => 'EquipmentController@update']);

    $router->delete('equipments/{id}', ['uses' => 'EquipmentController@delete']);
    // Equipments Endpoints --- start

    //Rents Endpoints --- start
    $router->get('rents', ['uses' => 'RentController@index']);
    
    $router->get('rents_books', ['uses' => 'RentController@rented_books']);

    $router->get('returned_books', ['uses' => 'RentController@returned_books']);
    
    $router->get('rents_equipments', ['uses' => 'RentController@rented_equipments']);

    $router->get('returned_equipments', ['uses' => 'RentController@returned_equipments']);

    $router->post('rents', ['uses' => 'RentController@store']);

    $router->put('rents/{id}', ['uses' => 'RentController@returnRent']);

});
