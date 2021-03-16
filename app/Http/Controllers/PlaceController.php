<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Place\{CreateRequest, UpdateRequest};
use App\Models\{User, Place};
use App\Facades\Helper;

class PlaceController extends BaseController
{
    use HasList, HasRetrieve;

    public function __construct()
    {

        $this->model = \App\Models\Place::class;
    }

    public function create(CreateRequest $request)
    {
        try {


            $data = $request->validated();

            $object = new $this->model();
            $object->name = $data['name'];
            $object->type = $data['type'];
            $object->parent_id = $data['parent_id'];
            $object->country_id = $data['country_id'];

            $object->save();


            return $this->_response($object);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $data = $request->validated();

            $object = $this->model::findOrFail($request->id);

            $object->name = $data['name'];
            $object->type = $data['type'];
            $object->parent_id = $data['parent_id'];
            $object->country_id = $data['country_id'];


            $object->save();

            return $this->_response($object);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function list(Request $request)
    {

        try {
            $result = [];
            $data = $this->model::all();

            foreach ($data as $object) {
                $obj = (object) $object->toArray();
                // $obj = (object) $object->transform();
                $obj->long_name = Helper::getFullNamePlace($object);

                
                $result[] = $obj;
            }

            return response()->json($result);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }

    public function search(Request $request)
    {

        try {

            $result = [];
            $data = null;

            if ($request->has('q')) {

                $places = $this->model::where('name', 'like', "%" . $request->q . "%")->take(10)->get();
            } else {

                $places = $this->model::take(10)->get();
            }

            foreach ($places as $place) {

                $obj = new \stdClass();
                $obj->id = $place->id;
                $obj->name = $place->name;


                $result[] = $this->search_transform($place);
            }

            return response()->json($result);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }

    private function search_transform(Place $place)
    {

        $obj = new \stdClass();
        $obj->id = $place->id;
        $obj->name = $place->name;

        $parent = $place->parent;

        if ($parent) {
            $obj->name .=  '-'  . $parent->name;
        }

        return $obj;
    }

    // public function beforeListResponse($response)
    // {
    //     dd(2);
    // }
}
