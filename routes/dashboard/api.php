<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\{CountryController, CategoryController};
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\Program\Medical\{CaseController};

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
    Route::get('/programs/medical/cases', [CaseController::class, 'list']);
    Route::post('/programs/medical/cases', [CaseController::class, 'create']);
    Route::put('/programs/medical/cases', [CaseController::class, 'update']);
    Route::get('/programs/medical/cases/{id}', [CaseController::class, 'retrieve']);
    Route::post('/programs/medical/cases/{id}/hide', [CaseController::class, 'markAsHidden']);
    Route::post('/programs/medical/cases/{id}/unhide', [CaseController::class, 'markAsVisible']);
    Route::post('/programs/medical/cases/{id}/archive', [CaseController::class, 'markAsArchived']);
    Route::post('/programs/medical/cases/{id}/unarchive', [CaseController::class, 'markAsUnarchived']);
    Route::post('/programs/medical/cases/{id}/post', [CaseController::class, 'markAsPosted']);
    Route::post('/programs/medical/cases/{id}/document', [CaseController::class, 'markAsDocumented']);
    Route::post('/programs/medical/cases/{id}/undocument', [CaseController::class, 'markAsUndocumented']);
});
