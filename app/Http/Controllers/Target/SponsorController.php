<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Sponsor\{CreateRequest , UpdateRequest};
use App\Facades\Helper;

use App\Models\{User , Sponsor , Donor};

class SponsorController extends BaseController {
    

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Sponsor::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();
            
            $purpose = $data['purpose_type']::find($data['purpose_id']);
            $donor = Donor::findOrfail($data['donor_id']);
            
            $obj  = Helper::AssignToSponsor($purpose ,$donor  , $data['percentage'] , true , $request);
            if(!$obj) throw $this->_exception('error in created data');
            return $this->_response($obj);
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

            $options = ['target' => $request->target , "places_ids" =>[ $request->place_id] ];


            $object->save($options);
            
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