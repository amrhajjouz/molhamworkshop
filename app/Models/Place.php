<?php

namespace App\Models;

use App\Models\{Country};

class Place extends BaseModel
{
    protected $table = 'places';
    protected $guarded = [];

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
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
    public function getFullNamePlace()
    {
        $text = $this->name;
        $object = $this;
        //if type = province that main it has no parent place
        if ($this->type == 'province' && isset($this->country_code)) {
            return json_decode($object->country->name, true)["ar"] . "-" . $text;
        }
        while (isset($object->parent)) {
            $object = $object->parent;
            $text =  $object->name . '-' . $text;
            if (!is_null($object->country_code)) $text = json_decode($object->country->name, true)["ar"] . "-" . $text;
        }
        return $text;
    }
}
