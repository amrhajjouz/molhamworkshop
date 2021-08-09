<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeSepaAccount extends Model
{
    protected $guarded = [];
    protected $table = "stripe_sepa_accounts";
    public $timestamps = false;

    public function payment_methods()
    {
        return $this->morphMany('App\Models\PaymentMethod', 'methodable');
    }

    public function apiTransform()
    {
        $obj = $this->toArray();
        return [
            'id' => $obj['id'],
            'stripe_payment_method_id' => $obj['stripe_payment_method_id'],
            'iban' => $obj['iban'],
        ];
    }
}
