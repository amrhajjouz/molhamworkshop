<?php

namespace App\Models;


use App\Common\Base\BaseModel;
use App\Models\{Cases, Country};

class Place extends BaseModel
{
     protected $table = 'places';
     
     const CITY = 'city';

     public function cases()
     {
          return $this->morphedByMany(Cases::class, 'placeable');
     }

     public function parent()
     {
          return $this->hasOne(self::class, 'id', 'parent_id');
     }
     public function country()
     {
          return $this->hasOne(Country::class, 'id', 'country_id');
     }

     public function transform()
     {

          $object = $this->toArray();
          $parent = $this->parent;
          $country = $this->country;

          if ($parent) {
               $parent->parent;
          }

          unset($this->parent);
          return array_merge($object, [
               'parent' => $parent,
               'country' => $country ? ['name' => $country->name] : null
          ]);
     }


     public function save($options = [])
     {

          if ($this->type !== "province")
               $this->country_id = null;

          return parent::save();
     }


     /*
     * optional transform this object and get long path of place with parents names 
     */

     public function long_name()
     {
          return \App\Facades\Helper::getFullNamePlace($this);
     }
}
