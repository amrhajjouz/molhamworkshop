<?php

namespace App\Models;

use App\Common\Base\BaseTargetModel;

class Campaign extends BaseTargetModel
{
     
     protected $table = 'campaigns';
     protected $guarded = [];
     protected $model_path = '\App\Models\Campaign';
     protected $casts = [
          'funded' => 'boolean'
     ];

     public function save($options =[]){
          return parent::save($options);
     }
     
     

     

    
}    
