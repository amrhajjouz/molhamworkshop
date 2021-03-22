<?php

namespace App\Models;

use App\Models\{Country, Section , Category};

use App\Common\Base\BaseModel;

class Sponsor extends BaseModel
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
          
          $donor = $this->donor;


          // $places = $this->places;
          // $_places = [];

          // if ($places) {
          //      foreach ($places as $item) {
          //           $_place = (object)[
          //                'id' => $item->id,
          //                'name' => $item->name,
          //                'text' => $item->name,
          //                'type' => $item->type,
          //           ];

          //           $_places[] = $_place;
          //      }
          // }

          $obj = $this->toArray();
          
          return (object)array_merge($obj , [ 
               'donor'=>[ 
                    'id'=> $donor->id, 
                    'name'=> $donor->name, 
                    'email'=> $donor->email, 
               ],  
          ]);
     }
     
}    
