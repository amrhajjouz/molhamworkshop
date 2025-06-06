<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SpaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::middleware('auth')->get('{url?}', [SpaController::class, 'index'])->where('url', '.*')->name('home');
