<?php

namespace App\Models;


use App\Common\Base\BaseTargetModel;
use PDO;

class Fundraiser extends BaseTargetModel
{

     protected $table = 'fundraisers';
     protected $guarded = [];
     protected $model_path = '\App\Models\Fundraiser';
     protected $has_places = false;
     protected $casts = [
          'verified' => 'boolean',
          'public_visibility' => 'boolean',
      ];

     public function donor()
     {
          return $this->hasOne('\App\Models\Donor', 'id', 'donor_id');
     }

     public function transform()
     {
          $obj = $this->toArray();
          $parent = $this->parent->toArray();
          $section = $this->parent->section;
          $donor = $this->donor;
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
               'donor' => $_donor

          ]);
     }

     public function save($options = [])
     {    
          // $newRecord = !($this->exists);


          // parent::save($options);

          // if ($newRecord) {

          // } else {

          // }

          return parent::save($options);
     }



}
