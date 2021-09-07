<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwishAccount extends Model
{
    protected $guarded = [];
    protected $table = "swish_accounts";
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
            'number' => $obj['number'],
        ];
    }
}
