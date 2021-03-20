<?php

namespace App\Models;

use App\Models\{Country, Section , Category};

use App\Common\Base\BaseModel;

class Sponsors extends BaseModel
{
     protected $table = 'sponsors';
     protected $guarded = [];

     protected $casts = [
          'active' => 'boolean',
     ];


     public function purpose(){
          return $this->belongsTo($this->purpose_type , 'purpose_id' , 'id');
     }
     
     public function donor(){
          return $this->belongsTo('App\Models\Donor' , 'donor_id' , 'id');
     }
     
     
     public function transform(){
          
          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;
          
          if(!is_null($section)){
               unset($section->created_at);
               unset($section->updated_at);
          }

          if(!is_null($category)){
               unset($category->created_for);
               unset($category->created_at);
               unset($category->updated_at);
          }

          unset($this->parent);

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

          $obj = $this->toArray();
          
          return (object)array_merge($obj , [ 
               'country'=>[ 
                    'name'=> $this->country->name 
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
               'section' =>$section,
               'category' =>$category,
          ]);
     }
     
}    
