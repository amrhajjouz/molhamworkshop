<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\PaymentMethod\{CreatePaymentMethodRequest, DeletePaymentMethodRequest};
use App\Models\{PaymentMethod, StripeCard};
use Exception;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class PaymentMethodController extends Controller
{
    public function create(Request $request)
    {
        try {
            
            if (!$request->has('stripe_setup_intent_id')) throw new ApiErrorException('invalid_request');
            
            $stripe = new StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');         
            
            $setupIntent = $stripe->setupIntents->retrieve($request->stripe_setup_intent_id);
            
            if (true /*$setupIntent->status == 'succeeded'*/) {
                
                $stripePaymentMethod = $stripe->paymentMethods->retrieve($setupIntent->payment_method);
                
                if ($stripePaymentMethod->type == 'card') {
                    
                    if (StripeCard::where('stripe_payment_method_id', $stripePaymentMethod->id)->exists()) throw new ApiErrorException('payment_method_already_exists');
                    
                    $data = [
                        'donor_id' => auth('donor')->user()->id,
                        'methodable_type' => 'stripe_card',
                        'methodable' => [
                            'stripe_payment_method_id' => $stripePaymentMethod->id,
                            'fingerprint' => $stripePaymentMethod->card->fingerprint,
                            'brand' => $stripePaymentMethod->card->brand,
                            'last4_digits' => $stripePaymentMethod->card->last4,
                            'expiry_month' => $stripePaymentMethod->card->exp_month,
                            'expiry_year' => $stripePaymentMethod->card->exp_year,
                            'country_code' => $stripePaymentMethod->card->country,
                        ],
                    ];
                    
                    $paymentMethod = PaymentMethod::create($data);
                    return handleResponse($paymentMethod->apiTransform());
                }
                
                else throw new ApiErrorException('invalid_payment_method');
                
            } else throw new ApiErrorException('invalid_payment_method');
            
        } catch (\Exception $e) {
            //return get_class ($e);
            throw new ApiErrorException($e);
        }
    }

    public function delete(DeletePaymentMethodRequest $request, $payment_method_id)
    {
        try {
            $paymentMethod = PaymentMethod::where([['id' , $payment_method_id] , ['donor_id' , auth('donor')->user()->id]])->first();
            if (!$paymentMethod) throw new Exception('invalid_payment_method');
            $paymentMethod->delete();
            return handleResponse(null);
        } catch (\Exception $e) {
            throw new ApiErrorException($e);
        }
    }

    public function retrieve(Request $request, $payment_method_id)
    {
        try {
            $paymentMethod = PaymentMethod::where([['id' , $payment_method_id] , ['donor_id' , auth('donor')->user()->id] ])->first();
            if (!$paymentMethod) throw new Exception('invalid_payment_method');
            return handleResponse($paymentMethod->apiTransform());
        } catch (\Exception $e) {
            throw new ApiErrorException($e);
        }
    }

    public function update(Request $request)
    {
        try {
            //   TODO
        } catch (\Exception $e) {
            throw new ApiErrorException($e);
        }
    }
}
