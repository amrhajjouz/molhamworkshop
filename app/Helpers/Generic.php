<?php

use App\Models\ApiError;
use App\Models\Scholarship;
use App\Models\Sponsorship;

function getLocaleName($locale)
{
    switch ($locale) {
        case 'ar' : return 'عربي'; break;
        case 'en' : return 'انجليزي'; break;
        case 'fr' : return 'فرنسي'; break;
        case 'de' : return 'ألماني'; break;
        case 'tr' : return 'تركي'; break;
        case 'es' : return 'اسباني'; break;
        default: return ; break;
    }
}


function getAvailableLocales()
{
    return [
        'ar' => 'عربي',
        'en' => 'انجليزي',
        'fr' => 'فرنسي',
        'de' => 'ألماني',
        'tr' => 'تركي',
        'es' => 'اسباني',
    ];
}

function handleResponse($response)
{
    if (is_array($response) && isset($response['error'])) {
        $apiError = ApiError::firstOrCreate(['code' => $response['error']]);
        return response()->json(['error' => ['code' => $apiError->code, 'message' => $apiError->message[app()->getLocale()]]], $apiError->status);
    } elseif (is_array($response) && isset($response['errors'])) {
        $errors = [];
        foreach ($response['errors'] as $key => $value) {
            $errors[$key] = [];
            foreach ($value as $msg) {
                $apiError = ApiError::firstOrCreate(['code' => $msg]);
                $errors[$key][] = ['code' => $msg, 'message' => $apiError->message[app()->getLocale()]];
            }
        }
        return response()->json(['error'=> collect($errors)->first()[0] ,'errors' => $errors ] , 400);
    }
    else return response()->json($response);
}

function getMorphedModel ($morph)
{
    return \Illuminate\Database\Eloquent\Relations\Relation::getMorphedModel($morph);
}

function getPaymentMethodType ($methodableType)
{
    $paymentMethodType = null;
    switch ($methodableType) {
        case 'stripe_card': $paymentMethodType = 'card'; break;
        case 'stripe_ideal_account': $paymentMethodType = 'ideal'; break;
        case 'stripe_sofort_account': $paymentMethodType = 'sofort'; break;
        case 'stripe_giropay_account': $paymentMethodType = 'giropay'; break;
        case 'stripe_sepa_account': $paymentMethodType = 'sepa'; break;
        case 'swish_account': $paymentMethodType = 'swish'; break;
    }
    return $paymentMethodType;
}

function authDonor () {
    return auth('donor')->user();
}

function stripeClient () {
    return new \Stripe\StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
}

function getTargetableAmount ($targetable) {
    
    // , $type, 
    $target = $targetable->target;
    $funded = $targetable->funded;
    $currencies = ['usd', 'eur', 'try', 'cad', 'sar', 'qar', 'aed'];
    $amounts = [];
    
    foreach ($currencies as $c) {
        $amounts['required'][$c] = $target->required;
        if (!in_array($target->targetable_type, ['scholarship' , 'sponsorship'])) {
            $amounts['received'][$c] = $target->received ;
            $amounts['left_to_complete'][$c] =  $target->left_to_complete ;
        }
    }
    return $amounts;
}

