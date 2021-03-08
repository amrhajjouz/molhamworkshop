<?php

namespace App\Models;

use App\Models\Country;

use App\Common\Base\BaseTargetModel;

class Cases extends BaseTargetModel
{
     protected $table = 'cases';
     protected $guarded = [];
     // protected $dateFormat = 'U';


     public function country(){
          return $this->belongsTo(Country::class , 'country_id' , 'id');
     }
     
     public function transform(){
          $obj = $this->toArray();
          return (object)array_merge($obj , [
               'country'=>[
                    'name'=> $this->country->name
               ]
          ]);
     }
     

     public function getFundedAttribute($data)
     {
          if($data) return true;
          return false;
     }    
    
     public function getCancelledAttribute($data)
     {
          if($data) return true;
          return false;
     }    
}    
