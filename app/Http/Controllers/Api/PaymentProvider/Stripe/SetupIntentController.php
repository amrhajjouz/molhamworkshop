<?php

namespace App\Http\Controllers\Api\PaymentProvider\Stripe;

use App\Http\Controllers\Controller;
use App\Exceptions\ApiErrorException;
use Illuminate\Http\Request;
use Exception;
use Stripe\StripeClient;

class SetupIntentController extends Controller
{
    public function create(Request $request)
    {
        try {
            
            if (!$request->has('stripe_payment_method_id')) throw new ApiErrorException('invalid_request');
            
            $stripe = new StripeClient('sk_test_rWaVeJAcQYStJcShQeoxWUHg005redZKzG');
            
            if (!auth('donor')->user()->stripe_customer_id) {
                $customer = $stripe->customers->create(['name' => 'Donor ' . auth('donor')->user()->id]);
                auth('donor')->user()->update(['stripe_customer_id' => $customer->id]);
            }            
            
            $setupIntent = $stripe->setupIntents->create([
              'customer' => auth('donor')->user()->stripe_customer_id,
              'payment_method' => $request->stripe_payment_method_id,
            ]);
            
            return handleResponse($setupIntent);
        } catch (\Exception $e) {
            throw new ApiErrorException($e);
        }
    }
}
