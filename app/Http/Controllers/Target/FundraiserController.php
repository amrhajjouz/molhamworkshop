<?php

namespace App\Http\Controllers\Target;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Requests\Target\Fundraiser\{CreateRequest , UpdateRequest};
use App\Models\{Fundraiser};

class FundraiserController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {

        $this->middleware('auth');
        $this->model = \App\Models\Fundraiser::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();

            $fundraiser = new $this->model();

            $fundraiser->verified = $data['verified'];
            $fundraiser->public_visibility = $data['public_visibility'];
            $fundraiser->donor_id = $data['donor_id'];
            $options = ['target'=> $data['target']];

            $fundraiser->save($options);
            
            return $this->_response($fundraiser->transform());
            
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
    
    public function update(UpdateRequest $request) {
        
        try {
            
            $fundraiser = $this->model::findOrFail($request->id);
            
            $data = $request->validated();
            $fundraiser->verified = $data['verified'];
            $fundraiser->public_visibility = $data['public_visibility'];
            $fundraiser->donor_id = $data['donor_id'];
            
            $options = ['target' => $request->target];

            $fundraiser->save($options);
            
            return $this->_response($fundraiser->transform());

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    public function list (Request $request) {
        
        try {
            $data = $this->model::all();
            
            return $this->_response($data);

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
}