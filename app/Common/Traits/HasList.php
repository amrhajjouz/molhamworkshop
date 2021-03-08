<?php

namespace App\Common\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasList{



    public function list(Request $request){

        $class_name = $this->model;
        
        return $this->_response($class_name::all());


    }

}
