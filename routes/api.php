<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{DonorController , AuthDonorController};

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


Route::group(['middleware' => 'guest'],function () {
    Route::get('/test', function () {
        return 'test 2021';
    });
    Route::post('/donors/authenticate' , [DonorController::class, 'authenticate'])->name('api.donors.authenticate');
    Route::post('/donors' , [DonorController::class, 'create'])->name('api.donors.create');
});


Route::group(['middleware' => 'auth_donor'],function () {
    Route::get('/donors/auth' , [AuthDonorController::class, 'retrieve'])->name('api.donors.auth.retrieve'); 
    Route::post('/donors/logout' , [AuthDonorController::class, 'logout'])->name('api.donors.auth.logout'); 
    Route::post('/donors/auth' , [AuthDonorController::class, 'update'])->name('api.donors.auth.update'); 
    Route::post('/donors/auth/delete' , [AuthDonorController::class, 'delete'])->name('api.donors.auth.delete'); 
    Route::post('/donors/auth/email' , [AuthDonorController::class, 'changeEmail'])->name('api.donors.auth.email.change'); 
    Route::post('/donors/auth/password' , [AuthDonorController::class, 'changePassword'])->name('api.donors.auth.password.change'); 
    Route::put('/donors/auth/preferences' , [AuthDonorController::class, 'updatePreferences'])->name('api.donors.auth.preferences.update'); 
    Route::get('/donors/auth/notification_preferences' , [AuthDonorController::class, 'listNotificationPreferences'])->name('api.donors.auth.notification_preferences.list'); 
    Route::put('/donors/auth/notification_preferences' , [AuthDonorController::class, 'updateNotificationPreferences'])->name('api.donors.auth.notification_preferences.update'); 
});
