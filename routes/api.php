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
    Route::post('/donors/authenticate' , [DonorController::class, 'authenticate'])->name('authenticate_donor');
    Route::post('/donors' , [DonorController::class, 'create'])->name('create_donor');
});


Route::group(['middleware' => 'auth_donor'],function () {
    Route::post('/donors/auth' , [AuthDonorController::class, 'update'])->name('update_auth_donor'); 
    Route::post('/donors/auth/delete' , [AuthDonorController::class, 'delete'])->name('delete_auth_donor'); 
    Route::get('/donors/auth' , [AuthDonorController::class, 'retrieve'])->name('retrieve_auth_donor'); 
    Route::post('/donors/auth/email' , [AuthDonorController::class, 'changeEmail'])->name('change_auth_donor_email'); 
    Route::post('/donors/auth/password' , [AuthDonorController::class, 'changePassword'])->name('change_auth_donor_password'); 
    Route::post('/donors/auth/preferences' , [AuthDonorController::class, 'updatePreferences'])->name('update_auth_donor_prefrences'); 
    Route::post('/donors/logout' , [AuthDonorController::class, 'logout'])->name('logout_donor'); 

});
