<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\{User, Country};

class CategoryController extends BaseController
{
    // use HasList;

    public function __construct()
    {

        $this->model = \App\Models\Category::class;
    }

    public function list(Request $request)
    {
        try {
            $class_name = $this->model;
            $data = [];

            if($request->has('created_for')){
                $data = $class_name::where('created_for' , $request->created_for)->get();
            }else{
                $data = $class_name::all();
            }
            return $this->_response($data);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
}
