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
            
            $case = new $this->model();

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->serial_number =Helper::getCaseSerialNumber(); //generate unique number 
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];


            $options = ['target' => $request->target , "places_ids" =>[ $request->place_id] ]; // will saved in parent target
            $case->save($options);

            
            return $this->_response($case);
            
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    public function update (UpdateRequest $request) {
        
        try {
            
            $data = $request->validated();

            $case = $this->model::findOrFail($request->id);

            $case->beneficiary_name = $data['beneficiary_name'];
            // $case->serial_number =Helper::getCaseSerialNumber();
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            $options = ['target' => $request->target, "places_ids" => [$request->place_id]]; //options for parent target


            $case->save($options);
            
            return $this->_response($case);

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
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
            throw $this->_exception($e->getMessage());
        }
    }
    
}