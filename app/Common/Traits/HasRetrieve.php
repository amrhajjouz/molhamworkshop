<?php

namespace App\Common\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasRetrieve{



    public function retrieve(Request $request , $id){
        try{
            $class_name = $this->model;
            
            $object = $class_name::findOrFail($id);
            
            if(method_exists($object , 'transform')){
                return $this->_response($object->transform());
            }else{
                // dd($object );
                return $this->_response($object);
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }


    }

}
