<?php

namespace App\Models;

use App\Models\Country;

use App\Common\Base\BaseTargetModel;

class Cases extends BaseTargetModel
{
     protected $table = 'cases';
     protected $guarded = [];
     protected $model_path = '\App\Models\Cases';
     protected $has_places = true;

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
          $places = $this->places;
          $_places = [];
     
          if($places){
               foreach ($places as $item) {
                    $_place = (object)[
                         'id' => $item->id,
                         'name' => $item->name,
                         'type' => $item->type,
                    ];

                    $_places [] = $_place;
               }
          }
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

               ],
               "places" => $_places
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
