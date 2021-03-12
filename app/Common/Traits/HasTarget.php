<?php

namespace App\Common\Traits;

use Illuminate\Support\Facades\Auth;
/*
* used this trait in models that extends from Base target and return relation
*/
trait HasTarget
{


  public function parent()
  {
    return $this->belongsTo('App\Models\Target', 'target_id', 'id');
  }
}
