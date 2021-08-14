<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\PaymentMethod\{CreatePaymentMethodRequest, DeletePaymentMethodRequest};
use App\Models\{PaymentMethod};
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    public function create(CreatePaymentMethodRequest $request)
    {
        try {
            $brands = ['visa', 'master'];
            $data = [
                'type' => "card",
                "stripe_payment_method_id" => $request->validated()['stripe_payment_method_id'],
                'fingerprint' => Str::random(20),
                'brand' => $brands[array_rand($brands)],
                'last4_digits' => rand(1000, 9999),
                'expiry_month' => rand(1, 12),
                'expiry_year' => rand(2021, 2030),
                'country_code' => "TR",
            ];
            $paymentMethod = new PaymentMethod();
            $paymentMethod->save($data);
            return handleResponse($paymentMethod->apiTransform());
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function delete(DeletePaymentMethodRequest $request, $payment_method_id)
    {
        try {
            PaymentMethod::findOrFail($payment_method_id)->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function retrieve(Request $request, $payment_method_id)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($payment_method_id);
            return handleResponse($paymentMethod->apiTransform());
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            //   TODO
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
