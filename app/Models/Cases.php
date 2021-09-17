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
          $isNew = !$this->exists;
          $options['target'] = $this->target;
          $place_id = $this->place_id;
          unset($this->target);
          unset($this->place_id);
          if ($isNew) {
               $this->serial_number = $this->getCaseSerialNumber();
               $options['target']['category_id'] = Category::where('created_for', 'Cases')->where('name', 'طبية')->first()->id;
          } else {
               unset($options['target']['category']);
          }
          $case = parent::save(['target' => $options['target']]);
          $this->places()->sync([$place_id]);
          return $case;
     }

     private function getCaseSerialNumber()
     {
          $year = date("Y");
          $month = date("m");
          $casesInThisMonth = Cases::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
          return $year . $month . ($casesInThisMonth + 1);
     }
}
