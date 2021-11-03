<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasscodeController;

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

Route::group([], function () {
          Route::post('/passcode/verification', [PasscodeController::class, 'verification'])->name('api.passcode.verification');
          Route::post('/passcode/check', [PasscodeController::class, 'check'])->name('api.passcode.check');
          Route::get('/passcode/timesheet/{id}', [PasscodeController::class, 'timesheet']);
          Route::post('/passcode/update-check', [PasscodeController::class, 'updateCheck'])->name('api.passcode.updateCheck');
});
