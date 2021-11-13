<?php

use App\Http\Controllers\Dashboard\BoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\LabelController;
use App\Http\Controllers\Dashboard\TaskController;

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

Route::middleware('auth')->group(function () {

    Route::get('/auth', function (Request $request) {
        return $request->user();
    });

    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);

    Route::get('/users', [UserController::class, 'list']);
    Route::get('/users/search', [UserController::class, 'search']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);

    // Place Routes
    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);

    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);


    // Boards Routes
    Route::get('/boards', [BoardController::class, 'list']);
    Route::post('/boards', [BoardController::class, 'create']);
    Route::put('/boards', [BoardController::class, 'update']);
    Route::get('/boards/search', [BoardController::class, 'search']);
    Route::get('/boards/{id}', [BoardController::class, 'retrieve']);
    Route::get('/boards/{id}/tasks', [BoardController::class, 'retrieveWithTasks']);

    // Labels Routes
    Route::get('/labels', [LabelController::class, 'list']);
    Route::post('/labels', [LabelController::class, 'create']);
    Route::put('/labels', [LabelController::class, 'update']);
    Route::get('/labels/search', [LabelController::class, 'search']);
    Route::get('/labels/{id}', [LabelController::class, 'retrieve']);
    Route::delete('/labels/{id}', [LabelController::class, 'remove']);

    // Tasks Routes
    Route::get('/tasks', [TaskController::class, 'list']);
    Route::post('/tasks', [TaskController::class, 'create']);
    Route::put('/tasks', [TaskController::class, 'update']);
    Route::get('/tasks/search', [TaskController::class, 'search']);
    Route::get('/tasks/{id}', [TaskController::class, 'retrieve']);
    Route::delete('/tasks/{id}', [TaskController::class, 'remove']);
});
