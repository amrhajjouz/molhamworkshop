<?php

namespace App\Models;

use App\Common\Base\BaseTargetModel;

class Campaign extends BaseTargetModel
{

     protected $table = 'campaigns';
     protected $guarded = [];
     protected $model_path = '\App\Models\Campaign'; //used in parent model
     protected $has_places = true; //used in parent model to check if this model has place
     protected $has_admins = true; //used in parent model to check if this model has admins

     protected $casts = [
          'funded' => 'boolean' //transform funded field as bool value 
     ];


     public function save($options = [])
     {
          return parent::save($options);
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
          // $category = $this->parent->category;
          $places = $this->places; //this has Many places
          $admins = $this->admins;
          $_places = [];

          foreach ($places as $item) {
               $long_name = $item->long_name(); // long_name() comes from Place Model retrive long name with parents names
               $_place = (object)[
                    'id' => $item->id,
                    'name' => $long_name,
                    'text' => $long_name,
                    'type' => $item->type,
               ];

               $_places[] = $_place;
          }

          $response = (object)array_merge($obj, [
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],
                    'section_id' => $target['section_id'],

               ],
               "places" => $_places ,
               "admins" => $admins,
          ]);

          if ($section) {
               $response->section = [
                    'name' => $section->name,
               ];
          }

          return $response;
     }
}
