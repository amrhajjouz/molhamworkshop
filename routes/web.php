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

Route::get('test', function (Request $rquest) {
    $brands = ['visa', 'master'];
    $data = [
        'donor_id' => 1,
        'methodable_type' => 'stripe_card',
        'methodable' => [
            "stripe_payment_method_id" => 'pm_sSwQ23XcVvbn3A90DfdZxcXc',
            'fingerprint' => Str::random(20),
            'brand' => $brands[array_rand($brands)],
            'last4_digits' => rand(1000, 9999),
            'expiry_month' => rand(1, 12),
            'expiry_year' => rand(2021, 2030),
            'country_code' => "TR",
        ],
    ];
    
    $paymentMethod = \App\Models\PaymentMethod::create($data);
    
    return $paymentMethod->apiTransform();
    
});

Route::middleware('auth')->get('{url?}', [SpaController::class, 'index'])->where('url', '.*')->name('home');
