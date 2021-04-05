<?php

namespace App\Http\Controllers\Target;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasRetrieve};
use Illuminate\Http\Request;
use App\Http\Requests\Target\Cases\{CreateRequest , UpdateRequest};
use App\Facades\Helper;

use App\Models\{User , Cases , Admin};

class CaseController extends BaseController {
     
    use HasRetrieve;

    public function __construct () {
        $this->middleware('auth');
        $this->model = \App\Models\Cases::class;
    }
    
    public function create ( CreateRequest $request) {
        try {

            $data = $request->validated();
            $case = new $this->model();

            $case->beneficiary_name = $data['beneficiary_name'];
            $case->serial_number =Helper::getCaseSerialNumber(); //generate unique number 
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            $options = ['target' => $request->target , "places_ids" =>[ $request->place_id] , 'admins_ids'=>$request->admins_ids ]; // will saved in parent target or as a relation for this model
            $case->save($options);

            
            return $this->_response($case);
            
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    public function update (UpdateRequest $request) {
        
        try {
            
            $data = $request->validated();

            $case = $this->model::findOrFail($request->id);

            $case->beneficiary_name = $data['beneficiary_name'];
            // $case->serial_number =Helper::getCaseSerialNumber();
            $case->country_id = $data['country_id'];
            $case->status = $data['status'];

            $options = ['target' => $request->target, "places_ids" => [$request->place_id] , 'admins_ids' => $request->admins_ids]; //options for parent target


            $case->save($options);
            
            return $this->_response($case);

        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    public function list (Request $request) {
        
        try {
            // $search_query = ($request->has('q') ? [['beneficiary_name', 'like', '%' . $request->q . '%']] : null);

            $cases = $this->model::orderBy('id', 'desc')->where(function($q)use($request){
                if($request->has('q')){
                    $q->where('beneficiary_name', 'like', '%' . $request->q . '%');
                    $q->orWhere('serial_number', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString();

            return $this->_response($cases);
            
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
    
    public function list_admins (Request $request , $id) {
        
        try {

            $case = $this->model::findOrFail($id);

            $admins = $case->admins()->with('user')->get();
            $admins = collect($admins)->groupBy('user_id');

            $admins = $this->transform_list_admins($admins);

            return $this->_response($admins);
            
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    private function transform_list_admins($admins){
        $return = [];
        
        foreach ($admins as $items) {
            $roles = [];
            foreach($items  as $item){
                array_push($roles , $item->role);
               
            }
            $item->role = $roles;
            $return [] = $item;
        }
        return $return;
    }

    public function get_contents(Request $request , $id){
        
        try {
            $locales = ['ar' , 'en'];
            $content_fields = ['title' , "details"];

            $model = $this->model::find($id);

            $contents = $model->contents;

            $content = [];
            foreach ($content_fields as $field) {
                foreach ($locales as $l) {
                    $default [$l]= null;
                    $content[$field] = $default;
                    
                }
            }

            foreach ($contents as $c){
                $content[$c->name][$c->locale] = $c->value;
            } 
            
            return $content;

        } catch (\Exception $th) {
            throw $this->_exception($th->getMessage());
        }
    }
    
    public function put_contents(Request $request , $id){

        $model = $this->model::find($id);

        foreach($request->all() as $title => $values){
            foreach($values  as $locale => $val){

                \App\Models\Content::updateOrCreate(
                     ['contentable_type' => 'App\Models\Cases', 'contentable_id' => $id, 'locale' => $locale, 'name' => $title],
                     ['value' => $val]
                );
            }
        }

        return $this->_response($model->contents);
    }
    
    
    
}