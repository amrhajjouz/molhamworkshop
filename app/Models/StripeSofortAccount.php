<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeSofortAccount extends Model
{
    protected $guarded = [];
    protected $table = "stripe_sofort_accounts";
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
        $obj = $this->toArray();
        return [
            'id' => $obj['id'],
            'stripe_payment_method_id' => $obj['stripe_payment_method_id'],
            'owner_name' => $obj['owner_name'],
            'country_code' => $obj['country_code'],

        ];
    }
}
