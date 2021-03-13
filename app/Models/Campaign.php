<?php

namespace App\Models;

use App\Common\Base\BaseTargetModel;

class Campaign extends BaseTargetModel
{

     protected $table = 'campaigns';
     protected $guarded = [];
     protected $model_path = '\App\Models\Campaign';
     protected $casts = [
          'funded' => 'boolean'
     ];

     public function save($options = [])
     {
          return parent::save($options);
     }

     public function transform()
     {
          $obj = $this->toArray();

          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;

          $response = (object)array_merge($obj, [
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],
                    'section_id' => $target['section_id'],

               ] 
          ]);

          if ($section) {
               $response->section = [
                    'name' => $section->name,
               ];
          }

          return $response;
     }
}
