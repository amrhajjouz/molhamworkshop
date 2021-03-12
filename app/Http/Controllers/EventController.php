<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use App\Http\Requests\Events\{CreateRequest , UpdateRequest};
use App\Models\{Event};
use PDO;

class EventController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Event::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();
            $object = new $this->model();

            $object->date = date('Y/m/d' , strtotime($data['date']));
            $object->verified = $data['verified'];
            $object->public_visibility = $data['public_visibility'];
            $object->implemented = $data['implemented'];
            if($data['implementation_date']){
                $object->implementation_date = date('Y/m/d' , strtotime($data['implementation_date']));
            }
            $object->youtube_video_url = $data['youtube_video_url'];

            $object->target = $data['target'];
            $object->save();
            // $object->save($data['target']);
            
            return $this->_response($object->transform());
            
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
    
    public function update(UpdateRequest $request) {
        
        try {
            
            $object = $this->model::findOrFail($request->id);
            
            $data = $request->validated();
            $object->date = date('Y/m/d' , strtotime($data['date']));
            $object->verified = $data['verified'];
            $object->public_visibility = $data['public_visibility'];
            $object->implemented = $data['implemented'];
            if($data['implementation_date']){
                $object->implementation_date = date('Y/m/d' , strtotime($data['implementation_date']));
            }
            $object->youtube_video_url = $data['youtube_video_url'];

            // $object->target = $data['target'];
            $object->save($data['target']);
            
            return $this->_response($object->transform());

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    public function list (Request $request) {
        
        try {
            $result =[];
            $data = $this->model::all();

            // foreach($data as $object){
            //     $result[] = $object->transform();
            // }
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            
            return ['error' => $e->getMessage()];
        }
    }
    
}