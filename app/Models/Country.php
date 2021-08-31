<?php

namespace App\Models;

class Country extends BaseModel
{
   protected $table = "countries";
   protected  $guarded = [];
   protected $casts = ['name' => 'json', 'nationality' => 'json'];
   public $timestamps = false;
}
