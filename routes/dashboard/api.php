<?php

use App\Http\Controllers\Dashboard\AccountBranchController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\DeductionRatiosController;
use App\Http\Controllers\Dashboard\DonationController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PurposeController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Services\Transactions\Model\JournalReversalProcessInput;
use App\Http\Services\Transactions\PartialRefundTransactionService;
use App\Http\Services\Transactions\RefundTransactionService;
use App\Http\Services\Transactions\TransactionService;
use App\Models\Donation;
use App\Models\Journals;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

/**
 * @param $id
 */
function convertToEPayment($id): void
{
    $manualTransactionService = new TransactionService();

    $payment = Payment::find($id);

    $payment->method = "paypal(paypal)";
    $payment->fee = $payment->amount * 8 / 100;
    $payment->reversed_amount = 0;
    $payment->status = "paid";
    $payment->save();

    $donations = Donation::withTrashed()->wherePaymentId($id)->get();

    foreach ($donations as $donation) {
        $donation->restore();
        $donation->method = "card(paypal)";
        $donation->save();
    }

    $journal = $payment->journal->replicate()->fill([
        "type" => "e_payment"
    ]);

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Transaction::truncate();
    Journals::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    $journal->save();
    $manualTransactionService->processEPayment($journal);
}

Route::middleware('auth')->group(function () {

    Route::get('/auth', function (Request $request) {
        return $request->user();
    });

    Route::get('/to/e-payment/{id}', function ($id) {
        convertToEPayment($id);
    });

    Route::get('/refund/{id}', function ($id) {
        convertToEPayment($id);
        $transaction = new RefundTransactionService();
        $transaction->processRefundTransaction(Journals::findOrFail($id), "test", true);
    });

    Route::get('/partial-refund/{id}', function ($id) {
        convertToEPayment($id);
        $transaction = new PartialRefundTransactionService();
        $transaction->processPartialRefundTransaction(Journals::findOrFail($id), "test", [1], true);
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
    Route::get('/donations', [DonationController::class, 'list']);
    Route::get('/payments', [PaymentController::class, 'list']);
    Route::post('/payments', [PaymentController::class, 'create']);
    Route::post('/payments/{paymentId}/reverse', [PaymentController::class, 'reverse']);
    Route::post('/payments/{id}/refund', [PaymentController::class, 'refund']);
    Route::get('/payments/accounts', [PaymentController::class, 'searchPaymentAccount']);

    //transactions
    Route::get('/transactions/{accountId}', [TransactionController::class, 'list']);

});
