<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Sponsorship\{CreateRequest , UpdateRequest};

use App\Models\{Sponsorship};

class SponsorShipController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Sponsorship::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();

            $sponsorship = new $this->model();
            $sponsorship->beneficiary_name = $data['beneficiary_name'];
            $sponsorship->beneficiary_birthdate =  $data['beneficiary_birthdate'];
            $sponsorship->country_id = $data['country_id'];
            $sponsorship->sponsored = 0;

            $options = ['target' => $request->target , "places_ids" =>[ $request->place_id] ]; // used in parent target
            $sponsorship->save($options);

            return $this->_response($sponsorship);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }
    
    public function update (UpdateRequest $request) {
        
        try {
            
            $sponsorship = $this->model::findOrFail($request->id);
            $data = $request->validated();

            $sponsorship->beneficiary_name = $data['beneficiary_name'];
            $sponsorship->beneficiary_birthdate = $data['beneficiary_birthdate'];
            $sponsorship->country_id = $data['country_id'];
            $sponsorship->sponsored = $data['sponsored'];

            $options = ['target' => $request->target , "places_ids" =>[ $request->place_id] ];


            $sponsorship->save($options);
            
            return $this->_response($sponsorship);
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

    public function list_sponsors(Request $request , $id){
      
        try {
            $sponsorship = Sponsorship::findOrFail($id);

            $sponsors= $sponsorship->sponsors;

            $res = [];
            foreach($sponsors  as $item){
                $res [] = $item->transform();
            }

            return $this->_response($res);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }

    }
    
    
}