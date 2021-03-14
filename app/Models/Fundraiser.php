<?php

namespace App\Models;


use App\Common\Base\BaseTargetModel;
use PDO;

class Fundraiser extends BaseTargetModel
{

     protected $table = 'fundraisers';
     protected $guarded = [];
     protected $model_path = '\App\Models\Fundraiser';

     protected $casts = [
          'verified' => 'boolean',
          'public_visibility' => 'boolean',
      ];

     public function transform()
     {
          $obj = $this->toArray();
          $parent = $this->parent->toArray();
          $section = $this->parent->section;
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
               'section'=>$section
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
