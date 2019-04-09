<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function(){

Route::resource('restaurants','Restaurant\Restaurantcontroller',['only' => ['index', 'show']]);
Route::resource('users','User\Usercontroller',['except' => ['create', 'edit']]);

Route::resource('users.restaurants','User\UserRestaurantcontroller',['except' => ['create','show','edit']]);
});
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');





