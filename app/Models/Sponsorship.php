<?php

namespace App\Models;

use App\Models\{Country, Section , Category};

use App\Common\Base\BaseTargetModel;
use stdClass;

class Sponsorship extends BaseTargetModel
{
     protected $table = 'sponsorships';
     protected $guarded = [];
     protected $has_places = true;

     protected $casts = [
          'sponsored' => 'boolean',
     ];
     protected $model_path = '\App\Models\Sponsorship';


     public function getBeneficiaryBirthdateAttribute($beneficiary_birthdate){
          return date('Y/m/d' , strtotime($beneficiary_birthdate));
     }
     

     public function country(){
          return $this->belongsTo(Country::class , 'country_id' , 'id');
     }

     public function sponsors(){
          return $this->hasMany('App\Models\Sponsor' , 'purpose_id' , 'id')->where('purpose_type' , '\App\Models\Sponsorship');
     }
     
     
     public function transform(){
          
          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;
          // $sponsors = $this->sponsors;
          // $_sponsors=[];

          // foreach($sponsors as $item){
          //      $donor = $item->donor;
          //      unset($item->donor);
          //      $_donor = new stdClass();
               
          //      $_donor->id = $donor->id;
          //      $_donor->email = $donor->email;
          //      $_donor->name = $donor->name;
          //      $_donor->text = $donor->name;
          //      $item->donor = $_donor;
          //      $_sponsors []= $item; 
          // }

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
               // 'spnonsors' => $_sponsors,
               // percentage to complete
               'percentage_to_complete' => 100 - $this->sponsors->sum('percentage')
          ]);
     }
     
}    
