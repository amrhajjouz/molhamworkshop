<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Campaigns\{CreateRequest , UpdateRequest};
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
            $object->save();

            return $this->_response($object);
            
        } catch (\Exception $e) {
            
            return ['error' => $e->getMessage()];
        }
    }
    

    public function update (UpdateRequest $request) {
        
        try {
            
            $object = $this->model::findOrFail($request->id);
            
            $data = $request->validated();

            unset($data['id']);
            // dd($data);
            $object->update($data);
            
            return $this->_response($object);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    
    public function list (Request $request) {
        
        try {
            return response()->json($this->model::all());            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}