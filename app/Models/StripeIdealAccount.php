<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeIdealAccount extends Model
{

    protected $guarded = [];
    protected $table = "stripe_ideal_accounts";
    public $timestamps = false;

    public function paymentMethod()
    {
        return $this->morphOne('App\Models\PaymentMethod', 'methodable');
    }

    public function apiTransform()
    {
        $obj = $this->toArray();
        return [
            'id' => $obj['id'],
            'stripe_payment_method_id' => $obj['stripe_payment_method_id'],
            'owner_name' => $obj['owner_name'],
            'bank_name' => $obj['bank_name'],

        ];
    }
}
