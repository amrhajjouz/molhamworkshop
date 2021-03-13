<?php

namespace App\Models;

use App\Models\{Country, Section , Category};

use App\Common\Base\BaseTargetModel;

class Sponsorship extends BaseTargetModel
{
     protected $table = 'sponsorships';
     protected $guarded = [];

     protected $casts = [
          'sponsored' => 'boolean',
     ];
     protected $model_path = '\App\Models\Sponsorship';


     public function getBeneficiaryBirthdateAttribute($beneficiary_birthdate){
          return date('Y/m/d' , strtotime($beneficiary_birthdate));
     }
     

     public function country(){
          return $this->belongsTo(Country::class , 'country_id' , 'id');
     }
     
     
     public function transform(){
          
          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;
          
          if(!is_null($section)){
               unset($section->created_at);
               unset($section->updated_at);
          }

          if(!is_null($category)){
               unset($category->created_for);
               unset($category->created_at);
               unset($category->updated_at);
          }

          unset($this->parent);

          $obj = $this->toArray();
          
          return (object)array_merge($obj , [ 
               'country'=>[ 
                    'name'=> $this->country->name 
               ],  
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],
                    'section_id' => $target['section_id'],
               ],
               'section' =>$section,
               'category' =>$category,
          ]);
     }
     
}    
