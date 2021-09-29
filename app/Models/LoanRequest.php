<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class LoanRequest extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at','receiving_date','return_date'];

    protected $casts = [
        'receiving_date'  => 'date:Y-m-d',
        'return_date' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'user_id',
        'amount',
        'receiving_date',
        'return_date',
        'status',
        'details',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
