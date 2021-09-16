<?php

namespace App\Traits;

trait HasPlace
{
    public function getPlaceAttribute()
    {
        return $this->places()->first();
    }

    public function places()
    {
        return $this->morphToMany('App\Models\Place', 'placeable');
    }
}
