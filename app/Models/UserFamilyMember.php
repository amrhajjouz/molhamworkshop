<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFamilyMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at', 'date_of_marriage', 'date_of_birth'];

    protected $casts = [
        'date_of_marriage' => 'date:Y-m-d',
        'date_of_birth' => 'date:Y-m-d',
    ];

    protected $enums = [
        'gender' => UserFamilyMember::class . ':nullable',
    ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
