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

            return $this->_response($res['sponsor']->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }
    
    public function update (UpdateRequest $request ) {
        try {
            
            $object = $this->model::findOrFail($request->id);

            $data = $request->validated();

            $purpose = $object->purpose;

            $current_total_without_this_sponsor = $purpose->total_sponsores_percentage([$object->id]);
            
            if((100 - $current_total_without_this_sponsor) < $data['percentage'] ){
                throw $this->_exception('big percentage');
            }

            $target = $purpose->parent;
            $required = $target->required;
            $real_amount = ($required * $request->percentage) / 100;
            $config_amount = config('general.least_sponsore_amount');
            $percentage = $request->percentage;

            if ($real_amount < $config_amount  && $purpose->percentage_to_complete() != $percentage
            ) {
                throw $this->_exception('at least must pay 10 dolar');
            }
   
            $object->percentage = $data['percentage'];
            $object->save();

            $model_type = null;

            if ($purpose instanceof \App\Models\Sponsorship) {
                $model_type = '\App\Models\Sponsorship';
            } else if ($purpose instanceof \App\Models\Student) {
                $model_type = '\App\Models\Student';
            }else{
                throw $this->_exception('missing data');
            }

            if($model_type == "\App\Models\Sponsorship"){
                $this->afterUpdateSponsership($purpose , $current_total_without_this_sponsor , $data);
            }
            return $this->_response($object->transform());
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    

    protected function afterUpdateSponsership($purpose , $current_total_without_this_sponsor , $data){
       
        if (($current_total_without_this_sponsor + $data['percentage']) >= 100) {
            $purpose->sponsored = true;
        } else {
            $purpose->sponsored = false;
        }

        $purpose->save();

    }
    
}