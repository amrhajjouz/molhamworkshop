<?php

namespace App\Models;

use App\Common\Base\BaseTargetModel;

class Campaign extends BaseTargetModel
{

     protected $table = 'campaigns';
     protected $guarded = [];
     protected $model_path = '\App\Models\Campaign';
     protected $has_places = true;
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
          $places = $this->places;
          $_places = [];

          if ($places) {
               foreach ($places as $item) {
                    $_place = (object)[
                         'id' => $item->id,
                         'name' => $item->name,
                         'text' => $item->name,
                         'type' => $item->type,
                    ];

                    $_places[] = $_place;
               }
          }
          // dd($places);

          $response = (object)array_merge($obj, [
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],
                    'section_id' => $target['section_id'],

               ] ,
               "places" => $_places
          ]);

          if ($section) {
               $response->section = [
                    'name' => $section->name,
               ];
          }

          return $response;
     }
}
