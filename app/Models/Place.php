<?php

namespace App\Models;

class Place extends BaseModel
{
    protected $table = 'places';
    protected $guarded = [];
    protected $casts = ['name' => 'json', 'fullname' => 'json'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function save($options = [])
    {
        if (isset($this->parent)) {
            $this->country_code = $this->parent->country_code;
        }

        $this->fullname = $this->getFullNamePlace();

        return parent::save();
    }

    /*
     * optional transform this object and get long path of place with parents names
     */
    public function getFullNamePlace()
    {
        $object = $this;
        $arFullname = $this->name['ar'];
        $enFullname = $this->name['en'];
        while (isset($object->parent)) {
            $object = $object->parent;
            $arFullname .= ', ' . $object->name['ar'];
            $enFullname .= ', ' . $object->name['en'];
        }
        return ['ar' => $arFullname . ', ' . $object->country->name['ar'], 'en' => $enFullname . ', ' . $object->country->name['en']];
    }
}
