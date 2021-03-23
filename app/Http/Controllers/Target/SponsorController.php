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
            
            $res  = Helper::AssignToSponsor($purpose ,$donor  , $data['percentage'] , true , $request);

            if($res['error']) throw $this->_exception($res['error']);

            return $this->_response($res['sponsor']);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }
    
    public function update (UpdateRequest $request , $id) {
        try {
            
            $object = $this->model::findOrFail($request->id);

            $data = $request->validated();

            $purpose = $object->purpose;

            $current_total_without_this_sponsor = $purpose->total_sponsores_percentage([$object->id]);
            
            if((100 - $current_total_without_this_sponsor) < $data['percentage'] ){
                throw $this->_exception('big percentage');
            }

            $object->percentage = $data['percentage'];
            

            if (($current_total_without_this_sponsor + $data['percentage']) >= 100) {
                $purpose->sponsored = true;
                $object->active = true;
            }else{
                $purpose->sponsored = false;
                $object->active = false;
            }

            $object->save();
            $purpose->save();

            
            
            return $this->_response($object);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    
}