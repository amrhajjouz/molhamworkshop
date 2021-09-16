<?php

namespace App\Models;

use App\Models\{Country, BaseTargetModel};
use App\Traits\HasPlace;

class Cases extends BaseTargetModel
{
     use HasPlace;

     protected $table = 'programs_cases';
     protected $guarded = [];


     public function country()
     {
          return $this->belongsTo(Country::class, 'country_code', 'code');
     }

     public function save(array $options = [])
     {
          $case = parent::save(['target' => $options['target']]);
          $this->places()->sync([$options['place_id']]);
          return $case;
     }

   
}
