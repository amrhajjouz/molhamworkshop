<?php

namespace App\Models;

use App\Models\Country;

use App\Common\Base\BaseTargetModel;

class SponsorShip extends BaseTargetModel
{
     protected $table = 'sponsor_ships';
     protected $guarded = [];

     protected $casts = [
          'sponsored' => 'boolean',
     ];
     protected $model_path = '\App\Models\SponsorShip';


     public function getBeneficiaryBirthdateAttribute($beneficiary_birthdate){
          return date('Y/m/d' , strtotime($beneficiary_birthdate));
     }
     

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
     
}    
