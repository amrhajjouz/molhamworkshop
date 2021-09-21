<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\{CaseController, CountryController, CategoryController, TargetController};
use App\Http\Controllers\Dashboard\PlaceController;

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
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);

    //Country Routes
    Route::get('/countries', [CountryController::class, 'list']);

    // Place Routes
    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);

    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);

    // Cases Routes
    Route::get('/cases', [CaseController::class, 'list']);
    Route::post('/cases', [CaseController::class, 'create']);
    Route::put('/cases', [CaseController::class, 'update']);
    Route::get('/cases/{id}', [CaseController::class, 'retrieve']);
    
    // Target Routes
    Route::post('/targets/{id}/hide', [TargetController::class, 'hide']);
    Route::post('/targets/{id}/un_hide', [TargetController::class, 'unHide']);
    Route::post('/targets/{id}/archive', [TargetController::class, 'archive']);
    Route::post('/targets/{id}/un_archive', [TargetController::class, 'unArchive']);
    Route::post('/targets/{id}/post', [TargetController::class, 'post']);
    Route::post('/targets/{id}/document', [TargetController::class, 'document']);
    Route::post('/targets/{id}/un_document', [TargetController::class, 'unDocument']);
});
