<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Campaign\{CreateRequest , UpdateRequest};


class CampaignController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Campaign::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();
            $campaign = new $this->model();

            $campaign->name = $data['name'];
            $campaign->funded = 0;

            $options = ['target' => $request->target, "places_ids" => $request->places_ids];

            $campaign->save($options);

            return $this->_response($campaign);
            
        } catch (\Exception $e) {
            
           throw $this->_exception($e->getMessage());
        }
    }
    

    public function update (UpdateRequest $request) {
        
        try {
            
            $campaign = $this->model::findOrFail($request->id);
            
            $data = $request->validated();

            $campaign->name = $data['name'];
            $campaign->funded = $data['funded'];

            $options = ['target' => $request->target, "places_ids" => $request->places_ids];
            $campaign->save($options);

            return $this->_response($campaign);

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