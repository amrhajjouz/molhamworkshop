<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DonorController, ConstantController , ShortcutController , ShortcutKeyController , PageController , BlogController};

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

Route::get('/constants/json', [ConstantController::class, 'listJson']);
Route::get('/constants/json2', [ConstantController::class, 'listJson2']);

Route::middleware('auth')->group(function ()  {
    
    Route::get('/auth', function (Request $request) {
        return $request->user();
    });

    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);

    Route::get('/users', [UserController::class, 'list']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);

    ////////////////// Constants // //////////////
    Route::get('/constants', [ConstantController::class, 'list']);
    Route::post('/constants', [ConstantController::class, 'create']);
    Route::put('/constants', [ConstantController::class, 'update']);
    Route::get('/constants/{id}', [ConstantController::class, 'retrieve']);
    Route::put('/constants/{constant}/contents', [ConstantController::class, 'create_update_contents']);
    
    

});

