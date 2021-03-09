<?php

namespace App\Common\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
trait HasList
{



    public function list(Request $request)
    {
        try {
            $class_name = $this->model;
            return $this->_response($class_name::all());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
            // return ['error' => $e->getMessage()];
        }
    }
}
