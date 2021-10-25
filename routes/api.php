<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\ReceiverTransactionController;
use App\Http\Controllers\LanguageController;
use \App\Http\Controllers\PaymentTransactionController;
use \App\Http\Controllers\PaymentController;
use \App\Http\Controllers\DonationController;
use \App\Http\Controllers\PayoutRequestController;
use \App\Http\Controllers\VoucherController;
use \App\Http\Controllers\PayoutController;
use \App\Http\Controllers\AgreementController;

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
;
Route::middleware('auth')->group(function ()  {

    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);

    Route::get('/users', [UserController::class, 'list']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/search', [DonorController::class, 'search']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);

    Route::get('/receivers', [ReceiverController::class, 'list']);
    Route::post('/receivers', [ReceiverController::class, 'create']);
    Route::put('/receivers', [ReceiverController::class, 'update']);
    Route::get('/receivers/{id}', [ReceiverController::class, 'retrieve']);

    Route::get('/receivers/{receiver}/accounts', [AccountController::class, 'list']);
    Route::get('/accounts/search', [AccountController::class, 'search']);
    Route::put('/receivers/{receiver}/accounts', [AccountController::class, 'update']);
    Route::post('/receivers/{receiver}/accounts', [AccountController::class, 'create']);

    Route::get('/receivers/{receiver}/transactions', [ReceiverTransactionController::class, 'list']);
    Route::post('/receivers/{receiver}/transactions', [ReceiverTransactionController::class, 'create']);
    Route::delete('/receivers/{receiver}/transactions/{transaction}', [ReceiverTransactionController::class, 'delete']);

    Route::get('/accounts/types', [AccountTypeController::class, 'list']);
    Route::get('/transactions/types', [ReceiverTransactionController::class, 'TypeList']);
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/currencies', [CurrencyController::class, 'list']);
    Route::get('/languages', [LanguageController::class, 'list']);

    Route::get('transactions/{category}', [PaymentTransactionController::class, 'list']);
    Route::get('donations', [DonationController::class, 'list']);
    Route::get('payments/received', [PaymentController::class, 'list']);
    Route::get('payments/spent', [PayoutController::class, 'list']);
    Route::delete('payment/{payment}', [PaymentController::class, 'delete']);

    Route::post('payments', [PaymentTransactionController::class, 'create']);
    Route::post('payments/transfer', [PaymentTransactionController::class, 'transfer']);
    Route::delete('/payment/transactions/{transaction}', [PaymentTransactionController::class, 'delete']);

    Route::get('payouts/requests/{payoutRequestId}/summary', [PayoutRequestController::class, 'payoutRequestSummary']);
    Route::post('payouts/requests', [PayoutRequestController::class, 'create']);
    Route::get('payouts/requests/list', [PayoutRequestController::class, 'list']);
    Route::get('payouts/requests/{requestId}/reviews', [PayoutRequestController::class, 'reviewsList']);
    Route::post('payouts/requests/{payoutRequestId}/reviews', [PayoutRequestController::class, 'reviewRequest']);
    Route::post('payouts/requests/{payoutRequestId}/voucher', [VoucherController::class, 'create']);
    Route::get('payouts/vouchers/list', [VoucherController::class, 'list']);
    Route::put('payouts/vouchers/{voucherId}/update-status', [VoucherController::class, 'updateStatus']);
    Route::get('payouts/vouchers/search', [VoucherController::class, 'search']);

    Route::get('agreements', [AgreementController::class, 'list']);
    Route::post('agreements', [AgreementController::class, 'create']);
    Route::put('agreements/{agreementId}', [AgreementController::class, 'update']);
    Route::post('agreements/{agreementId}/update-state', [AgreementController::class, 'updateState']);
    Route::get('agreements/{agreementId}', [AgreementController::class, 'retrieveAgreement']);
    Route::get('agreements/{agreementId}/vouchers', [AgreementController::class, 'assignedVouchersList']);
    Route::put('agreements/{agreementId}/assign/{voucherId}', [AgreementController::class, 'assignVoucherToAgreement']);
    Route::put('agreements/{agreementId}/invoke/{voucherId}', [AgreementController::class, 'invokeVoucherFromAgreement']);
    Route::get('agreements/{agreementId}/summary', [AgreementController::class, 'summary']);
});
