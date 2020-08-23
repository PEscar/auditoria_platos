<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware('auth:api')->get('/users', 'Api\UserController@index')->name('api.users.index');
// Route::middleware('auth:api')->get('/users/{id}', 'Api\UserController@show')->name('api.users.show');
// Route::middleware('auth:api')->delete('/users/{id}', 'Api\UserController@show')->name('api.users.show');

Route::middleware('auth:api')->group(function () {

    Route::get('/users', 'Api\UserController@index')->name('api.users.index');
    Route::get('/users/{id}', 'Api\UserController@show')->name('api.users.show');

    Route::delete('/users/{id}', 'Api\UserController@destroy')->name('api.users.destroy');

    Route::put('/users/update/{id}', 'Api\UserController@update')->name('api.users.update');

    Route::post('/users/create', 'Api\UserController@store')->name('api.users.create');
});

Route::get('/orders/create', 'Api\VentaController@importOrderFromTiendaNube')->name('tiendanube.orders.create');
Route::get('/orders/update', 'Api\VentaController@updateOrderFromTiendaNube')->name('tiendanube.orders.update');