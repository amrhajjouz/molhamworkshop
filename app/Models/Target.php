<?php

namespace App\Models;


use App\Common\Base\BaseModel;

class Target extends BaseModel
{
     public function child(){
          return $this->belongsTo($this->model_type , 'id' , 'target_id');
     }
     

     public function GetInstanceAttribute(){
     


    //  $class = \\App\\Models\\ucfirst($this->model_type);

    //  return $class::find($this->instance_id);

     }

}
