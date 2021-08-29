<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected  $guarded = [];
    protected $casts = ['name' => 'json'];
    public $timestamps = false;
}
