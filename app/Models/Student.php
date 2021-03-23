<?php

namespace App\Models;

use App\Models\Country;

use App\Common\Base\BaseTargetModel;

class Student extends BaseTargetModel
{
     protected $table = 'students';
     protected $guarded = ["semesters_funded", "semesters_left"];
     protected $model_path = '\App\Models\Student';
     protected $has_places = true;

     const PAUSED = 'paused';
     const NOT_FOUNDED = 'not_funded';
     const CURRENTLY_FUNDED = 'currently_founded';
     const FULLY_FUNDED = 'fully_funded';

     public function parent()
     {
          return $this->belongsTo('App\Models\Target', 'target_id', 'id');
     }

     public function country()
     {
          return $this->belongsTo(Country::class, 'country_id', 'id');
     }

     public function sponsors()
     {
          return $this->hasMany('App\Models\Sponsor', 'purpose_id', 'id')->where('purpose_type', '\App\Models\Student');
     }
     

     public function transform()
     {    

          $obj = $this->toArray();
          $target = $this->parent->toArray();
          $places = $this->places;
          $_places = [];

          if ($places) {
               foreach ($places as $item) {
                    $_place = (object)[
                         'id' => $item->id,
                         'name' => $item->name,
                         'text' => $item->name,
                         'type' => $item->type,
                    ];

                    $_places[] = $_place;
               }
          }

          unset($obj['parent']);
          
          return (object)array_merge($obj, [
               'country' => [
                    'name' => $this->country->name
               ],
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],

               ],
               "places" => $_places ,
               'percentage_to_complete' => 100 - $this->sponsors->sum('percentage')

          ]);
     }

     public function getStatusAttribute($status)
     {
          $return = null;

          switch ($status) {

               case self::PAUSED:
                    $return = 'منتهية';
                    break;
               case self::NOT_FOUNDED:
                    $return = 'غير مؤمنة';
                    break;
               case self::CURRENTLY_FUNDED:
                    $return = 'مؤمنة جزئيا';
                    break;
               case self::FULLY_FUNDED:
                    $return = 'تم تأمينها';
                    break;
               default:
                    $return = $status;
                    break;
          }

          return $return;
     }

     public function save($options = [])
     {
          $newRecord = !($this->exists);
          parent::save($options);
          //create
          if ($newRecord) {
               $this->status = self::NOT_FOUNDED;
          } else {
               if ($this->semesters_funded >= $this->semesters_count) {
                    $this->status = self::FULLY_FUNDED;
               }
               //update
          }

          $this->semesters_left = $this->semesters_count - $this->current_semester;
          $this->semesters_funded = $this->semesters_count - $this->current_semester;



          return parent::save($options);
     }

     public function set_not_funded()
     {
          $this->status = self::NOT_FOUNDED;
          $this->save();
     }

     public function set_paused()
     {
          $this->status = self::PAUSED;
          $this->save();
     }

     public function set_currently_funded()
     {
          $this->status = self::CURRENTLY_FUNDED;
          $this->save();
     }

     public function set_fully_funded()
     {
          $this->status = self::FULLY_FUNDED;
          $this->save();
     }


     //return sum total sponsored percentage except any id in array
     public function total_sponsores_percentage($ignore = [])
     {

          return $this->sponsors()->whereNotIn('id', $ignore)->sum('percentage');
     }
     
     //return sum total sponsored percentage except any id in array
     public function percentage_to_complete()
     {

          return 100 - $this->sponsors()->sum('percentage');
     }
}
