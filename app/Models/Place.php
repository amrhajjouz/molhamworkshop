<?php

namespace App\Models;


use App\Models\{Cases, Country};

class Place extends BaseModel
{
    protected $table = 'places';
    protected $guarded= [];

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
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function transform()
    {
        $object = $this->toArray();
        $parent = $this->parent;
        $country = $this->country;
        $locale = app()->getLocale();
        if($country) $country->name = json_decode($country->name);
        if ($parent) {
            $parent->parent;
        }

        unset($this->parent);
        return array_merge($object, [
            'parent' => $parent,
            'country' => $country ? ['name' => $country->name[$locale]] : null
        ]);
    }

    public function save($options = [])
    {
        if ($this->type !== "province")
            $this->country_code = null;

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
