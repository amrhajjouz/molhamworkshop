<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    protected $table = 'donation_items';
    protected $guarded = [];
    public $timestamps = false;

    public function purpose()
    {
        return $this->morphTo();
    }
}
