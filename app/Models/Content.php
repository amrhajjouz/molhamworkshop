<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
     protected $table = 'contents';
     protected $guarded = [];
     use SoftDeletes;

     public function contentable()
     {
          return $this->morphTo();
     }
}
