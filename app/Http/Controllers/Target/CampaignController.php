<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Target\Campaign\{CreateRequest , UpdateRequest};
use App\Facades\Helper;

use App\Models\{User , Campaign};

class CampaignController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Campaign::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            
            $data = $request->validated();

            $object = new $this->model();
            $object->name = $data['name'];
            $object->funded = 0;
            $object->save($data['target']);

            return $this->_response($object);
            
        } catch (\Exception $e) {
            
           throw $this->_exception($e->getMessage());
        }
    }
    

    public function update (UpdateRequest $request) {
        
        try {
            
            $object = $this->model::findOrFail($request->id);
            
            $data = $request->validated();

            $object->name = $data['name'];
            $object->funded = $data['funded'];

            $object->save($data['target']);

            return $this->_response($object);

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    
    public function list (Request $request) {
        
        try {
            return response()->json($this->model::all());            
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
}