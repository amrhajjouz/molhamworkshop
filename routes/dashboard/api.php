<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\LoanRequestController;
use App\Http\Controllers\Dashboard\AdvancePaymentRequestController;
use App\Http\Controllers\Dashboard\TravelRequestController;
use App\Http\Controllers\Dashboard\UserFamilyMemberController;
use App\Http\Controllers\Dashboard\UserContractController;

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

    // profile Routes
    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);
    Route::post('/profile/employment_data', [ProfileController::class, 'employment_data']);
    Route::post('/profile/residence_data', [ProfileController::class, 'residence_data']);
    Route::post('/profile/contact_data', [ProfileController::class, 'contact_data']);
    Route::post('/profile/experiences_and_skills', [ProfileController::class, 'experiences_and_skills']);
    Route::post('/profile/additional_data', [ProfileController::class, 'additional_data']);
    Route::post('/profile/education', [ProfileController::class, 'education']);

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

    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);

    // Member Routes
    Route::get('/members', [MemberController::class, 'list']);
    Route::post('/members', [MemberController::class, 'create']);
    Route::put('/members', [MemberController::class, 'update']);
    Route::get('/members/search', [MemberController::class, 'search']);
    Route::get('/members/{id}', [MemberController::class, 'retrieve']);
    Route::delete('/members/{id}', [MemberController::class, 'delete']);

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

    // Travel Requests Routes
    Route::get('/travel_requests', [TravelRequestController::class, 'list']);
    Route::post('/travel_requests', [TravelRequestController::class, 'create']);
    Route::put('/travel_requests', [TravelRequestController::class, 'update']);
    Route::get('/travel_requests/search', [TravelRequestController::class, 'search']);
    Route::get('/travel_requests/{id}', [TravelRequestController::class, 'retrieve']);
    Route::delete('/travel_requests/{id}', [TravelRequestController::class, 'delete']);

    // User Family Members Routes
    Route::get('/user_family_members', [UserFamilyMemberController::class, 'list']);
    Route::post('/user_family_members', [UserFamilyMemberController::class, 'create']);
    Route::put('/user_family_members', [UserFamilyMemberController::class, 'update']);
    Route::get('/user_family_members/search', [UserFamilyMemberController::class, 'search']);
    Route::get('/user_family_members/{id}', [UserFamilyMemberController::class, 'retrieve']);
    Route::delete('/user_family_members/{id}', [UserFamilyMemberController::class, 'delete']);

    // User Contracts Routes
    Route::get('/user_contracts', [UserContractController::class, 'list']);
    Route::post('/user_contracts', [UserContractController::class, 'create']);
    Route::put('/user_contracts', [UserContractController::class, 'update']);
    Route::get('/user_contracts/search', [UserContractController::class, 'search']);
    Route::get('/user_contracts/{id}', [UserContractController::class, 'retrieve']);
    Route::delete('/user_contracts/{id}', [UserContractController::class, 'delete']);
});
