<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Cases\{CreateRequest , UpdateRequest};
use App\Facades\Helper;

use App\Models\{User , Cases};

class CaseController extends BaseController {
     
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Cases::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            

            $data = $request->validated();
            
            $object = new $this->model();
            $object->beneficiary_name = $data['beneficiary_name'];
            $object->serial_number =Helper::getCaseSerialNumber();
            $object->country_id = $data['country_id'];
            $object->status = $data['status'];
            // $object->funded = 0;
            // $object->cancelled = 0;
            $options = ['target' => $request->target , "places" => $request->places ];
            $object->save($options);

            
            return $this->_response($object);
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function update (UpdateRequest $request) {
        
        try {
            
            $data = $request->validated();

            $object = $this->model::findOrFail($request->id);
            $object->beneficiary_name = $data['beneficiary_name'];
            $object->serial_number =Helper::getCaseSerialNumber();
            $object->country_id = $data['country_id'];
            $object->status = $data['status'];
            

            $options = ['target' => $request->target , "places" => $request->places ];


            $object->save($options);
            
            return $this->_response($object);

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
            // return ['error' => $e->getMessage()];
        }
    }
    
    public function list (Request $request) {
        
        try {
            $result =[];
            $data = $this->model::all();

            foreach($data as $object){
                $result[] = $object->transform();
            }
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            
            return ['error' => $e->getMessage()];
        }
    }
    
}