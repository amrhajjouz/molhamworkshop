<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeIdealAccount extends Model
{

    protected $guardes = [];
    protected $table = "stripe_ideal_accounts";
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s' ];

    public function payment_methods()
    {
        return $this->morphMany('App\Models\PaymentMethod', 'methodable');
    }

    
    public function transform(){
    //TODO
    }

}
