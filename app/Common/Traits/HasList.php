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
            $response = $class_name::all();
            
            $response = $this->beforeListResponse($response);

            return $this->_response($response);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
            // return ['error' => $e->getMessage()];
        }
    }

    protected function beforeListResponse($lists){
        return $lists;
    }
}
