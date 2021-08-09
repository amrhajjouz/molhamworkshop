<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeCard extends Model
{
    protected $guarded = [];
    protected $table = "stripe_cards";
    public $timestamps = false;

    public function payment_methods()
    {
        return $this->morphMany('App\Models\PaymentMethod', 'methodable');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'code', 'country_code');
    }

    public function apiTransform()
    {
        $card = $this->toArray();
        return [
            'id' => $card['id'],
            'stripe_payment_method_id' => $card['stripe_payment_method_id'],
            'fingerprint' => $card['fingerprint'],
            'brand' => $card['brand'],
            'last4_digits' => $card['last4_digits'],
            'expiry_month' => $card['expiry_month'],
            'expiry_year' => $card['expiry_year'],
            'country_code' => $card['country_code'],
        ];
    }
}
