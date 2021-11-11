<?php

namespace App\Models;

use App\Models\{BaseTargetModel};

class Project extends BaseTargetModel
{
     
     protected $table = 'programs_projects';
     protected $guarded = [];
     protected $casts = ['funded' => 'boolean'];


     public function save(array $options = [])
     {
         $isNewCase = !$this->exists;
          //extract target fields from this 
          $options['target'] = [];
          foreach (['required', 'beneficiaries_count',  'is_hidden', 'category_id'] as $field) {
               if (isset($this->$field)) {
                    $options['target'][$field] = $this->$field;
                    unset($this->$field);
               }
          }
          if ($isNewCase) {
          } else {
               unset($options['target']['category']);
          }
          $case = parent::save(['target' => $options['target']]);
          return $case;

     }

}
