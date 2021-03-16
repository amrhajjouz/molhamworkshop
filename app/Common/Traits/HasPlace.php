<?php

namespace App\Common\Traits;

use Illuminate\Support\Facades\Auth;
/*
* used this trait in models that extends from Base target and return relation
*/
trait HasPlace
{


 public function places()
 {
   return $this->morphToMany('App\Models\Place', 'placeable');
 }
}
