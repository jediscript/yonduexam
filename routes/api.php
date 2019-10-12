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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//list all users
Route::get('users', 'UserController@index');

//show a user
Route::get('users/{id}', 'UserController@show');

//create a new user
Route::post('users', 'UserController@store');

//update a user
Route::put('users/{id}', 'UserController@update');

//delete a user
Route::delete('users/{id}', 'UserController@destroy');
