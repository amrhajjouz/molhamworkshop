<?php

namespace App\Models;

use App\Models\{BaseTargetModel};
use App\Traits\HasPlace;

class Sponsorship extends BaseTargetModel
{
     use HasPlace;
     
     protected $table = 'programs_sponsorships';
     protected $guarded = [];

     public function save(array $options = [])
     {
         $isNewSponsorships = !$this->exists;
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
          if ($isNewSponsorships) {
          } else {
               unset($options['target']['category']);
          }
          $sponsorships = parent::save(['target' => $options['target']]);
          $this->places()->sync([$placeId]);
          return $sponsorships;

     }

}
