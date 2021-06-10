<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends BaseModel
{
     use SoftDeletes;

     protected $table = 'comments';
     protected $guarded = [];
     protected $appends = ['user'];



     public function commentable()
     {
          return $this->morphTo();
     }


     public function getUserAttribute()
     {

          return $this->attributes['user'] = $this->creator->toArray();
     }
    
     public function getCreatedAtAttribute($created_at)
     {

          return $this->attributes['created_at'] = date('Y-m-d H:i:s' , strtotime($created_at));
     }


}
