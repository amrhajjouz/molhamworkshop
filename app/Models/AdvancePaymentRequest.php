<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvancePaymentRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at','receiving_date'];

    protected $casts = [
        'receiving_date'  => 'date:Y-m-d',
    ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
