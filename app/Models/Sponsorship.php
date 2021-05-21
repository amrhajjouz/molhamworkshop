<?php

namespace App\Models;

use App\Models\{Country};

use App\Common\Base\BaseTargetModel;
use App\Common\Traits\{HasContent , HasNote};


class Sponsorship extends BaseTargetModel
{
     use HasContent , HasNote;

     protected $table = 'sponsorships';
     protected $guarded = [];
     protected $has_places = true; //used in parent model to check if this model has places
     protected $model_path = '\App\Models\Sponsorship'; //used in parent model
     protected $has_admins = true; //used in parent model to check if this model has admins

     protected $casts = [
          'sponsored' => 'boolean',
     ];

     /* 
      * return beneficiary_birthdate in custom format Y/m/d 
     */
     public function getBeneficiaryBirthdateAttribute($beneficiary_birthdate)
     {
          return date('Y/m/d', strtotime($beneficiary_birthdate));
     }


     public function country()
     {
          return $this->belongsTo(Country::class, 'country_id', 'id');
     }

     public function sponsors()
     {
          return $this->morphMany('App\Models\Sponsor', 'purpose', 'purpose_type', null, 'id');
     }


     public function transform()
     {

          $target = $this->parent->toArray();
          $section = $this->parent->section;
          $category = $this->parent->category;
          $admins = $this->admins;


          if (!is_null($section)) {
               unset($section->created_at);
               unset($section->updated_at);
          }

          if (!is_null($category)) {
               unset($category->created_for);
               unset($category->created_at);
               unset($category->updated_at);
          }

          unset($this->parent);

          $places = $this->places;
          $_places = [];

          foreach ($places as $item) {
               $long_name = $item->long_name(); // retrive long name of place with parents names
               $_place = (object)[
                    'id' => $item->id,
                    'name' => $long_name,
                    'text' => $long_name,
                    'type' => $item->type,
               ];

               $_places[] = $_place;
          }

          $obj = $this->toArray();

          return (object)array_merge($obj, [
               'country' => [
                    'name' => $this->country->name
               ],
               'target' => [
                    'required' => $target['required'],
                    'visible' => $target['visible'],
                    'beneficiaries_count' => $target['beneficiaries_count'],
                    'documented' => $target['documented'],
                    'archived' => $target['archived'],
                    'section_id' => $target['section_id'],
               ],
               "places" => $_places,
               'section' => $section,
               'category' => $category,
               'admins' => $admins,
               'percentage_to_complete' => 100 - $this->sponsors->sum('percentage')
          ]);
     }


     /* 
      * return sum total sponsored percentage except any id in array 
      *  
     */

     public function total_sponsores_percentage($ignore = [])
     {

          return $this->sponsors()->whereNotIn('id', $ignore)->sum('percentage');
     }

     /* 
      * return what value required to complete percentage to 100%
     */

     public function percentage_to_complete()
     {
          return 100 - $this->sponsors()->sum('percentage');
     }




     /* 
      * Abstracted from HasContent Trait ti determin what fields are required fot this model
     */
     public static function get_content_fields()
     {
          return [
               'title', 'details'
          ];
     }
}
