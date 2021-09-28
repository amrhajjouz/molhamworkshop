<?php

use App\Http\Controllers\Dashboard\AccountBranchController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\DeductionRatiosController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PurposeController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/users/search', [UserController::class, 'search']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/search', [DonorController::class, 'search']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);
    // Place Routes
    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);

    // Country Routes
    Route::get('/currencies', [CurrencyController::class, 'list']);
    Route::get('/currencies/{currency}/rate', [CurrencyController::class, 'getRate']);

    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);

    //Accounts
    Route::get('/accounts/search', [AccountController::class, 'search']);
    Route::get('/accounts', [AccountController::class, 'list']);
    Route::post('/accounts', [AccountController::class, 'create']);
    Route::put('/accounts', [AccountController::class, 'update']);
    Route::get('/accounts/{accountId}', [AccountController::class, 'retrieve']);

    //account branches
    Route::get('account_branches', [AccountBranchController::class, 'listMain']);
    Route::post('/account_branches', [AccountBranchController::class, 'create']);
    Route::put('/account_branches', [AccountBranchController::class, 'update']);
    Route::get('/account_branches/search', [AccountBranchController::class, 'search']);
    Route::post('/account_branches/{id}', [AccountBranchController::class, 'create']);
    Route::get('/account_branches/{accountId}', [AccountBranchController::class, 'retrieve']);

    //account branches
    Route::get('/deduction_ratios/search', [DeductionRatiosController::class, 'search']);
    Route::get('/deduction_ratios', [DeductionRatiosController::class, 'list']);
    Route::post('/deduction_ratios', [DeductionRatiosController::class, 'create']);
    Route::put('/deduction_ratios', [DeductionRatiosController::class, 'update']);
    Route::get('/deduction_ratios/{accountId}', [DeductionRatiosController::class, 'retrieve']);
    Route::delete('/deduction_ratios/{deductionRatios}', [DeductionRatiosController::class, 'delete']);

    //purposes
    Route::get('/purposes/search', [PurposeController::class, 'search']);

    //payments
    Route::post('/payments', [PaymentController::class, 'create']);
    Route::get('/payments/accounts', [PaymentController::class, 'searchPaymentAccount']);

});
