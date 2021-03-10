<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\SponsorShip\{CreateRequest , UpdateRequest};
use App\Facades\Helper;

use App\Models\{User  , SponsorShip};

class SponsorShipController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\SponsorShip::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();

            $object = new $this->model();
            $object->beneficiary_name = $data['beneficiary_name'];
            // $object->beneficiary_birthdate = date('Y/m/d' , strtotime($data['beneficiary_birthdate']));
            $object->beneficiary_birthdate =  $data['beneficiary_birthdate'];
            $object->country_id = $data['country_id'];
            $object->sponsored = 0;
            $object->save();

            return $this->_response($object);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }
    
    public function update (UpdateRequest $request) {
        
        try {
            
            $object = $this->model::findOrFail($request->id);
            $data = $request->validated();

            $object->beneficiary_name = $data['beneficiary_name'];
            $object->beneficiary_birthdate = $data['beneficiary_birthdate'];
            $object->country_id = $data['country_id'];
            $object->sponsored = $data['sponsored'];
            
            $object->save();
            
            return $this->_response($object);
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