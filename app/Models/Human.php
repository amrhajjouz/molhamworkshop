<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{

    protected $fillable = [
        'name',
        'last_name',
        'father',
        'mother',
        'email',
    ];


}
