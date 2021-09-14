<?php

namespace App\Models;

use App\Models\{Country, BaseTargetModel};

class Cases extends BaseTargetModel
{

     protected $table = 'programs_cases';
     protected $guarded = [];


     public function country()
     {
          return $this->belongsTo(Country::class, 'country_code', 'code');
     }

     public function save(array $options = [])
     {
          return parent::save(['target' => $options['target']]);
     }
}
