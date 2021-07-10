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


    ////////////////// Shortcut /////////////////
    Route::get('/shortcuts', [ShortcutController::class, 'list']);
    Route::post('/shortcuts', [ShortcutController::class, 'create']);
    Route::put('/shortcuts', [ShortcutController::class, 'update']);
    Route::get('/shortcuts/{id}', [ShortcutController::class, 'retrieve']);
    Route::get('/shortcuts/{id}/keys', [ShortcutController::class, 'list_keys']);
    Route::put('/shortcuts/{shortcut}/contents', [ShortcutController::class, 'create_update_contents']);

    ////////////////// Shortcut Keys /////////////////
    Route::post('/shortcuts_keys/{shortcut_id}', [ShortcutKeyController::class, 'create']);
    Route::put('/shortcuts_keys/{shortcut_key}/contents', [ShortcutKeyController::class, 'create_update_contents']);

    /////////////////////// Pages /////////////////////////
    Route::get('/pages', [PageController::class, 'list']);
    Route::post('/pages', [PageController::class, 'create']);
    Route::put('/pages', [PageController::class, 'update']);
    Route::get('/pages/{id}', [PageController::class, 'retrieve']);
    Route::put('/pages/{page}/contents', [PageController::class, 'create_update_contents']);

    /////////////////////// Blogs /////////////////////////
    Route::get('/blogs', [BlogController::class, 'list']);
    Route::post('/blogs', [BlogController::class, 'create']);
    Route::put('/blogs', [BlogController::class, 'update']);
    Route::get('/blogs/{id}', [BlogController::class, 'retrieve']);
    Route::put('/blogs/{blog}/contents', [BlogController::class, 'create_update_contents']);


});

