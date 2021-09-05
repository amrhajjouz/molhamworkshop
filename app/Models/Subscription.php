<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'first_billing_time' => 'datetime:Y-m-d H:i:s',
        'next_billing_time' => 'datetime:Y-m-d H:i:s',
        'last_billing_time' => 'datetime:Y-m-d H:i:s',
        'final_billing_time' => 'datetime:Y-m-d H:i:s',
        'started_at' => 'datetime:Y-m-d H:i:s',
        'suspended_at' => 'datetime:Y-m-d H:i:s',
        'ended_at' => 'datetime:Y-m-d H:i:s',
        'canceled_at' => 'datetime:Y-m-d H:i:s',
        'has_handling_payment' => 'boolean',
    ];

    public function save($options = [])
    {
        if (!$this->exists) {
            do {
                $this->reference = Str::random(17);
            } while (Subscription::where('reference', $this->reference)->exists());
        }
        return parent::save($options);
    }

    public function donor()
    {
        return $this->belongsTo("App\Models\Donor", 'donor_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class , 'renewal_for' , 'id');
    }

}
