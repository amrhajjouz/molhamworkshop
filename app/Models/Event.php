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
          $parent = $this->parent;
          unset( $obj['parent']);
          return (object)array_merge($obj, [
               'target' => [
                    'required' => $parent->required
               ],
          ]);
     }

     public function save($options = [])
     {    
          // dd($options);
          $newRecord = !($this->exists);

          // if (isset($this->target) && is_array($this->target)) {
          //      $options = $this->target;
          // }

          // if ($this->target) {
          //      unset($this->target);
          // }

          parent::save($options);
          //create
          if ($newRecord) {

          } else {

          }

          return parent::save($options);
     }



}
