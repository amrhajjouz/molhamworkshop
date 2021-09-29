<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\HumanController;
use App\Http\Controllers\Dashboard\LoanRequestController;
use App\Http\Controllers\Dashboard\AdvancePaymentRequestController;

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


    // Place Routes
    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);


    // Human Routes
    Route::get('/humans', [HumanController::class, 'list']);
    Route::post('/humans', [HumanController::class, 'create']);
    Route::put('/humans', [HumanController::class, 'update']);
    Route::get('/humans/search', [HumanController::class, 'search']);
    Route::get('/humans/{id}', [HumanController::class, 'retrieve']);
    Route::delete('/humans/{id}', [HumanController::class, 'delete']);

    // Loan Requests Routes
    Route::get('/loan_requests', [LoanRequestController::class, 'list']);
    Route::post('/loan_requests', [LoanRequestController::class, 'create']);
    Route::put('/loan_requests', [LoanRequestController::class, 'update']);
    Route::get('/loan_requests/search', [LoanRequestController::class, 'search']);
    Route::get('/loan_requests/{id}', [LoanRequestController::class, 'retrieve']);
    Route::delete('/loan_requests/{id}', [LoanRequestController::class, 'delete']);

    // Advance Payment Request Routes
    Route::get('/advance_payment_requests', [AdvancePaymentRequestController::class, 'list']);
    Route::post('/advance_payment_requests', [AdvancePaymentRequestController::class, 'create']);
    Route::put('/advance_payment_requests', [AdvancePaymentRequestController::class, 'update']);
    Route::get('/advance_payment_requests/search', [AdvancePaymentRequestController::class, 'search']);
    Route::get('/advance_payment_requests/{id}', [AdvancePaymentRequestController::class, 'retrieve']);
    Route::delete('/advance_payment_requests/{id}', [AdvancePaymentRequestController::class, 'delete']);


    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);
});
