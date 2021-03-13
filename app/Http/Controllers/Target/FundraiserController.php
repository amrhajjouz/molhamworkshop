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

            $object = new $this->model();

            $object->verified = $data['verified'];
            $object->public_visibility = $data['public_visibility'];

            $object->save($data['target']);
            
            return $this->_response($object->transform());
            
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
    
    public function update(UpdateRequest $request) {
        
        try {
            
            $object = $this->model::findOrFail($request->id);
            
            $data = $request->validated();
            $object->verified = $data['verified'];
            $object->public_visibility = $data['public_visibility'];
            
            $object->save($data['target']);
            
            return $this->_response($object->transform());

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