<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\{UserController , NotificationTemplateController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonorController;

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

Route::get('/test', function (Request $request) {
    return fillVariables('My name is {name}, age is {age}', ['name' => 'Mohamd', 'age' => 27]);
});

Route::middleware('auth')->group(function ()  {

    Route::get('/auth', function (Request $request) {
        return $request->user();
    });

    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);
    Route::get('/profile/notifications', [ProfileController::class, 'listNotifications']);

    Route::get('/users', [UserController::class, 'list']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);
    Route::get('/users/{user}/notifications', [UserController::class, 'listNotifications']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);

    /////////////////////// NotificationTemplate /////////////////////////
    Route::get('/notifications_types', [NotificationTemplateController::class, 'list']);
    Route::post('/notifications_types', [NotificationTemplateController::class, 'create']);
    Route::put('/notifications_types', [NotificationTemplateController::class, 'update']);
    Route::get('/notifications_types/{id}', [NotificationTemplateController::class, 'retrieve']);
    
});
