<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasRetrieve{



    public function retrieve(Request $request , $id){
        
        try{
            $class_name = $this->model;
            
            $object = $class_name::findOrFail($id);
            
            if(method_exists($object , 'transform')){
                return response()->json($object->transform());
            }else{
                return response()->json($object);
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }


    }

}
