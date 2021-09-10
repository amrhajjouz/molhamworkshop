<?php

namespace App\Traits;

trait HasPlace
{
    public function place()
    {
        return $this->hasOne('App\Models\Place', 'id', 'place_id');
    }
}
