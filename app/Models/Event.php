<?php

namespace App\Models;

// use App\Common\Traits\HasTarget;

use App\Common\Base\BaseTargetModel;

class Event extends BaseTargetModel
{
     
     // use HasTarget;

     protected $table = 'events';
     protected $guarded = [];
     protected $model_path = '\App\Models\Event';//used in parent model
     protected $has_places = true;//used in parent model to check if this model has place

     protected $casts = [
          'verified' => 'boolean',
          'public_visibility' => 'boolean',
          'implemented' => 'boolean',
      ];

     public function donor(){
          return $this->hasOne('\App\Models\Donor' , 'id' , 'donor_id');
     }
     

     public function transform()
     {

          $obj = $this->toArray();

          $target = $this->parent->toArray();
          $places = $this->places;
          $donor = $this->donor;
          $_donor = null;
          if($donor){
               $_donor = (object)[
                    'id' => $donor->id ,
                    'name' => $donor->name ,
                    'text' => $donor->name ,
               ];
          }

          $_places = [];
               foreach ($places as $item) {
                    $long_name = $item->long_name();// long_name() comes from Place Model retrive long name with parents names
                    $_place = (object)[
                         'id' => $item->id,
                         'name' => $long_name,
                         'text' => $long_name,
                         'type' => $item->type,
                    ];

                    $_places[] = $_place;
               }
          unset( $obj['parent']);
          return (object)array_merge($obj, [
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],

               ],
               'places' => $_places ,
               'donor' => $_donor
          ]);
     }

     public function save($options = [])
     {    

          return parent::save($options);
     }



}
