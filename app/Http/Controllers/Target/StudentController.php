<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Student\{CreateRequest , UpdateRequest};
use App\Facades\Helper;

use App\Models\{User , Student};

class StudentController extends BaseController {
    
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Student::class;
    }
    
    public function create ( CreateRequest $request) {
        try {
            $data = $request->validated();
            $object = new $this->model();
            $object->name = $data['name'];
            $object->country_id = $data['country_id'];
            $object->semesters_count = $data['semesters_count'];
            $object->current_semester = $data['current_semester'];
            // $object->semesters_funded = $data['semesters_funded'];
            // $object->semesters_left = $data['semesters_left'];
            // $object->status = $data['status'];
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
            // dd($data);
             $object->name = $data['name'];
            //  $object->target = $data['target'];
             $object->country_id = $data['country_id'];
             $object->semesters_count = $data['semesters_count'];
             $object->current_semester = $data['current_semester'];

             $object->save($data['target']);
            
            return $this->_response($object->transform());

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
            // return ['error' => $e->getMessage()];
        }
    }
    
    public function list (Request $request) {
        
        try {
            $result =[];
            $data = $this->model::all();

            foreach($data as $object){
                $result[] = $object->transform();
            }
            
            return $this->_response($result);
            
        } catch (\Exception $e) {
            
            return ['error' => $e->getMessage()];
        }
    }
    
}