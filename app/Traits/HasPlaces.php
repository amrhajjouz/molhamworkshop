<?php

namespace App\Traits;

trait HasPlaces
{
    public function places()
    {
        return $this->morphToMany('App\Models\Place', 'placeable');
    }
}
