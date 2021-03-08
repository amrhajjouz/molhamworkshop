<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Case\{CreateRequest , UpdateRequest};
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
            
            

            $data = $request->all();
            // Create User
            $object = new Cases();
            $object->beneficiary_name = $data['beneficiary_name'];
            $object->serial_number =Helper::getCaseSerialNumber();
            $object->country_id = $data['country_id'];
            $object->funded = 0;
            $object->cancelled = 0;
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
            $object->update($data);
            
            return $this->_response($object);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    
    public function list (Request $request) {
        
        try {
            
            return response()->json(User::all());            
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}