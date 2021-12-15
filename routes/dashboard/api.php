<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\OfficeController;
use App\Http\Controllers\Dashboard\JustificationsController;

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
    Route::get('/profile/timesheet', [ProfileController::class, 'timesheet']);
    Route::get('/profile/generate-qr-code', [ProfileController::class, 'generateQrCode']);
    Route::get('/profile/justifications', [ProfileController::class, 'justificationsList']);
    Route::post('/profile/retriveJustification', [ProfileController::class, 'retriveJustification']);
    Route::post('/profile/sendJustification', [ProfileController::class, 'sendJustification']);

    Route::get('/users', [UserController::class, 'list']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::delete('/users/delete-user-device/{id}', [UserController::class, 'deleteUserDevice']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);

    // Timesheet
    Route::get('/timesheet/single/{id}', [UserController::class, 'timesheet']);
    Route::get('/timesheet/justifications', [JustificationsController::class, 'list']);
    Route::get('/timesheet/justifications/{id}', [JustificationsController::class, 'retrive']);
    Route::post('timesheet/justification/reject', [JustificationsController::class, 'reject']);
    Route::post('timesheet/justification/approve', [JustificationsController::class, 'approve']);

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

    // Branches Routes
    Route::get('/offices', [OfficeController::class, 'list']);
    Route::post('/offices', [OfficeController::class, 'create']);
    Route::put('/offices', [OfficeController::class, 'update']);
    Route::get('/offices/{id}', [OfficeController::class, 'retrieve']);
});
