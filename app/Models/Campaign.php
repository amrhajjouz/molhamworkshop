<?php

namespace App\Models;
use App\Common\Traits\HasTarget;

use App\Common\Base\BaseTargetModel;

class Campaign extends BaseTargetModel
{
     use HasTarget;
     protected $table = 'campaigns';
     protected $guarded = [];
     protected $model_path = '\App\Models\Campaign';


     

     public function getFundedAttribute($data)
     {
          if($data) return true;
          return false;
     }    
    
}    
