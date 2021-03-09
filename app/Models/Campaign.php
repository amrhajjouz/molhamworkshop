<?php

namespace App\Models;


use App\Common\Base\BaseTargetModel;

class Campaign extends BaseTargetModel
{
     protected $table = 'campaigns';
     protected $guarded = [];


     

     public function getFundedAttribute($data)
     {
          if($data) return true;
          return false;
     }    
    
}    
