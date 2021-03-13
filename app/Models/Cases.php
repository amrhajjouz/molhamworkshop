<?php

namespace App\Models;

use App\Models\Country;

use App\Common\Base\BaseTargetModel;

class Cases extends BaseTargetModel
{
     protected $table = 'cases';
     protected $guarded = [];
     protected $model_path = '\App\Models\Cases';


     public function country()
     {
          return $this->belongsTo(Country::class, 'country_id', 'id');
     }

     public function transform()
     {
          $obj = $this->toArray();
          
          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;
          
          $response =  (object)array_merge($obj, [
               'country' => [
                    'name' => $this->country->name
               ],
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],
                    'section_id' => $target['section_id'],

               ]
          ]);
          
          if($section){
               $response->section = [
                    'name' =>$section->name,
               ];
          }
       
          if($category){
               $response->category = [
                    'name' =>$category->name,
               ];
          }
          return $response;
     }

     public function save($options = [])
     {
          
          return parent::save($options);
     }

     public function getFundedAttribute($data)
     {
          if ($data) return true;
          return false;
     }

     public function getCancelledAttribute($data)
     {
          if ($data) return true;
          return false;
     }
}
