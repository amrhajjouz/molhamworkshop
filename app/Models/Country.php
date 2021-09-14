<?php

namespace App\Models;

use App\Model\BaseModel;

class Country extends BaseModel
{
   protected $table = "countries";
   protected  $guarded = [];
   protected $casts = ['name' => 'json', 'nationality' => 'json'];
   public $timestamps = false;

}