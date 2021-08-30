<?php

namespace App\Facades;

use App\Models\{Place};

class Helper
{

    // return city with parents names
    public static function getFullNamePlace(Place $place)
    {
        $text = $place->name;
        $object = $place;
        //if type = province that main it has no parent place
        if ($object->type == 'province' && isset($object->country_id)) {
            return $object->country->name  . "-" . $text;
        }
        while (isset($object->parent)) {
            $object = $object->parent;
            $text =  $object->name . '-' . $text;
            if (!is_null($object->country_code)) {
                $object->country->name = json_decode($object->country->name , true);
                $text = $object->country->name[app()->getLocale()] . "-" . $text;
            }
        }
        return $text;
    }


}