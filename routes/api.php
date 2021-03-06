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

Route::middleware('auth')->group(function ()  {
    
    Route::get('/auth', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/profile', 'Auth\ProfileController@update_info');
    Route::post('/profile/password', 'Auth\ProfileController@change_password');
    
    Route::get('/users', 'UserController@list');
    Route::post('/users', 'UserController@store');
    Route::get('/users/{id}', 'UserController@retrieve');
});