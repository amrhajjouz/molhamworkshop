<?php

namespace App\Models;


use App\Common\Base\BaseTargetModel;

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
          // $newRecord = !($this->exists);


          // parent::save($options);

          // if ($newRecord) {

          // } else {

          // }

          return parent::save($options);
     }



}
