<?php

namespace App\Models;

use App\Models\{Country};
use App\Common\Traits\HasContent;
use App\Common\Base\BaseTargetModel;

class Cases extends BaseTargetModel
{
     use HasContent;

     protected $table = 'cases';
     protected $guarded = [];
     protected $model_path = '\App\Models\Cases'; //used in parent model
     protected $has_places = true; //used in parent model to check if this model has place
     protected $has_admins = true; //used in parent model to check if this model has admins

     /* 
      * append this attribute from content relations 
      * transform this attribute by getTitleAttribute() , getDetailsAttribute()
     */
     protected $appends = ['title' , 'details'];

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
          $admins = $this->admins;
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
               "admins" => $admins,

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

          $creator = $this->creator;
          if ($creator) {
               $response->creator = [
                    'name' => $creator->name,
                    'email' => $creator->email,
               ];
          }

          return $response;
     }



     public function getTitleAttribute($title)
     {
          return $this->get_content('title');
     }


     public function getDetailsAttribute($title)
     {
          return $this->get_content('details');
     }


     /* 
      * Abstracted from HasContent Trait 
     */
     public static function get_content_fields(){
          return [
               'title' , 'details'
          ];
     }




  
}
