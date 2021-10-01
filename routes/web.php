<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;

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

Route::get('/test', function () {
    print url('login') . '<br>';
    print route('login');
    return ;
});

Route::middleware('auth')->get('{url?}', [SpaController::class, 'index'])->where('url', '.*')->name('home');
