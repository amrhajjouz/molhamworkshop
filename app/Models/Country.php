<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
   protected $table = "countries";
   protected $guarded = [];
   protected $casts = ['name' => 'json', 'nationality' => 'json'];
   public $timestamps = false;
}