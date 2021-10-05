<?php

namespace App\Models;

class Content extends BaseModel
{
     protected $table = 'contents';
     protected $casts = ["proofreading_checked"=>"boolean" , "auto_generated"=>"boolean"];

     public function contentable()
     {
          return $this->morphTo();
     }
}
