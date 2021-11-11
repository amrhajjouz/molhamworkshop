<?php

namespace App\Models;

use App\Models\{Country, BaseTargetModel};
use App\Traits\HasPlace;

class Fundraiser extends BaseTargetModel
{
     use HasPlace;
     
     protected $table = 'programs_fundraisers';
     protected $guarded = [];

     public function save(array $options = [])
     {
         $isNewFundraiser = !$this->exists;
          //extract target fields from this 
          $options['target'] = [];
          foreach (['required', 'beneficiaries_count',  'is_hidden', 'category_id'] as $field) {
               if (isset($this->$field)) {
                    $options['target'][$field] = $this->$field;
                    unset($this->$field);
               }
          }
          $placeId = $this->place_id;
          unset($this->place_id);
          if ($isNewFundraiser) {
          } else {
               unset($options['target']['category']);
          }
          $fundraiser = parent::save(['target' => $options['target']]);
          $this->places()->sync([$placeId]);
          return $fundraiser;

     }

}
