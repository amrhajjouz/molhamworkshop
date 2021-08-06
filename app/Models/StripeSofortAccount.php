<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeSofortAccount extends Model
{

    protected $guardes = [];
    protected $table = "stripe_sofort_account";
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s' ];

    public function payment_methods()
    {
        return $this->morphMany('App\Models\PaymentMethod', 'methodable');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'code', 'country_code');
    }

    public function transform(){
        //TODO
        }
        
}
