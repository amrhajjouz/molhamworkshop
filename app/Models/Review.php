<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s',];


    public function donor()
    {
        return $this->belongsTo("App\Models\Donor", 'donor_id');
    }

    public function save($options = [])
    {
        if (!$this->exists) {
            $this->donor_id = authDonor()->id;
        }
        return parent::save($options);
    }
}
