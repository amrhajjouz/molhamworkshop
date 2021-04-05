<?php

namespace App\Models;


use App\Common\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends BaseModel
{
     protected $table = 'contents';
     use SoftDeletes;

     public function contentable()
     {
          return $this->morphTo();
     }
}
