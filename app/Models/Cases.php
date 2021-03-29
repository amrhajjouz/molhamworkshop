<?php

namespace App\Models;

use App\Models\Country;

use App\Common\Base\BaseTargetModel;

class Cases extends BaseTargetModel
{
     protected $table = 'cases';
     protected $guarded = [];
     protected $model_path = '\App\Models\Cases'; //used in parent model
     protected $has_places = true; //used in parent model to check if this model has place

     public function country()
     {
          return $this->belongsTo(Country::class, 'country_id', 'id');
     }

     /* 
      * this function called to return this model with all relations
      * Notice : this just for one object because it has big data 
     */

     public function transform()
     {
          $obj = $this->toArray();

          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;

          $place = $this->places()->first(); //get First becaust this has one place
          $_places = [];

          if ($place) {
               $long_name = $place->long_name(); // long_name() comes from Place Model retrive long name with parents names

               $_place = (object)[
                    'id' => $place->id,
                    'name' => $long_name,
                    'text' => $long_name,
                    'type' => $place->type,
               ];

               $_places[] = $_place;
               $obj['place_id'] = $place->id;
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
               "places" => $_places,

          ]);

          if ($section) {
               $response->section = [
                    'name' => $section->name,
               ];
          }

          if ($category) {
               $response->category = [
                    'name' => $category->name,
               ];
          }

          return $response;
     }

     public function save($options = [])
     {

          return parent::save($options);
     }
}
