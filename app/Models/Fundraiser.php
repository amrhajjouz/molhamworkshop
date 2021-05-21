<?php

namespace App\Models;


use App\Common\Base\BaseTargetModel;
use App\Common\Traits\{HasContent , HasNote};


class Fundraiser extends BaseTargetModel
{
     use HasContent , HasNote;

     protected $table = 'fundraisers';
     protected $guarded = [];
     protected $model_path = '\App\Models\Fundraiser'; //used in parent model
     protected $has_places = false; //used in parent model to check if this model has place
     protected $has_admins = true; //used in parent model to check if this model has admins

     protected $casts = [
          'verified' => 'boolean',
          'public_visibility' => 'boolean',
      ];

     public function donor()
     {
          return $this->hasOne('\App\Models\Donor', 'id', 'donor_id');
     }


     /* 
      * this function called to return this model with all relations
      * Notice : this just for one object because it has big data 
     */

     public function transform()
     {
          $obj = $this->toArray();
          $parent = $this->parent->toArray();
          $section = $this->parent->section;
          $donor = $this->donor;
          $admins = $this->admins;

          $_donor = null;
          if ($donor) {
               $_donor = (object)[
                    'id' => $donor->id,
                    'name' => $donor->name,
                    'text' => $donor->name,
               ];
          }


          if($section){
               unset($section->create_at);
               unset($section->update_at);
          }

          unset( $obj['parent']);
          return (object)array_merge($obj, [
               'target' => [
                    'required' => $parent['required'],
                    'documented' => $parent['documented'],
                    'archived' => $parent['archived'],
                    'visible' => $parent['visible'],
                    'section_id' => $parent['section_id'],
               ],
               'section'=>$section ,
               'donor' => $_donor ,
               'admins'=>$admins,

          ]);
     }

     public function save($options = [])
     {    

          return parent::save($options);
     }


     /* 
      * Abstracted from HasContent Trait ti determin what fields are required fot this model
     */
     public static function get_content_fields()
     {
          return [
               'title', 'details'
          ];
     }


}
