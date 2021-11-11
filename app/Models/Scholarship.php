<?php

namespace App\Models;

use App\Models\{BaseTargetModel};
use App\Traits\HasPlace;

class Scholarship extends BaseTargetModel
{
     use HasPlace;
     
     protected $table = 'programs_scholarships';
     protected $guarded = [];

     public function save(array $options = [])
     {
         $isNewScholarship = !$this->exists;
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
          if ($isNewScholarship) {
          } else {
               unset($options['target']['category']);
          }
          $scholarship = parent::save(['target' => $options['target']]);
          $this->places()->sync([$placeId]);
          return $scholarship;

     }

}
