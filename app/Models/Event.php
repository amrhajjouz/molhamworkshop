<?php

namespace App\Models;

use App\Common\Traits\HasTarget;

use App\Common\Base\BaseTargetModel;

class Event extends BaseTargetModel
{
     use HasTarget;

     protected $table = 'events';
     protected $guarded = [];
     protected $model_path = '\App\Models\Event';

     protected $casts = [
          'verified' => 'boolean',
          'public_visibility' => 'boolean',
          'implemented' => 'boolean',
      ];

     public function transform()
     {

          $obj = $this->toArray();

          $target = $this->parent->toArray();

          unset( $obj['parent']);
          return (object)array_merge($obj, [
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],

               ]
          ]);
     }

     public function save($options = [])
     {    

          return parent::save($options);
     }



}
