<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s', 'reviewed' => 'boolean'];


    public function donor()
    {
        return $this->belongsTo("App\Models\Donor", 'donor_id');
    }
}
