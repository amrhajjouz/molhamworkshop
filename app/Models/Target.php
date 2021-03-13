<?php

namespace App\Models;


use App\Common\Base\BaseModel;
use App\Models\Section;

class Target extends BaseModel
{

     protected $casts = [
          'documented' => 'boolean',
          'visible' => 'boolean',
          'archived' => 'boolean',
     ];

     protected $guarded = [];

     public function child()
     {
          return $this->belongsTo($this->model_type, 'id', 'target_id');
     }

     public function category()
     {
          return $this->belongsTo('App\Models\Category', 'category_id', 'id');
     }

      public function section(){
           return $this->belongsTo(Section::class , 'section_id' , 'id');
      }

     public function GetInstanceAttribute()
     {



          //  $class = \\App\\Models\\ucfirst($this->model_type); 

          //  return $class::find($this->instance_id);

     }
}
