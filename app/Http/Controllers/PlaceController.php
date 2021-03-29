<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Common\Traits\{HasList, HasRetrieve};
use Illuminate\Http\Request;
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

            $place = new $this->model();
            $place->name = $data['name'];
            $place->type = $data['type'];
            $place->parent_id = $data['parent_id'];
            $place->country_id = $data['country_id'];

            $place->save();


            return $this->_response($place);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            $data = $request->validated();

            $place = $this->model::findOrFail($request->id);

            $place->name = $data['name'];
            $place->type = $data['type'];
            $place->parent_id = $data['parent_id'];
            $place->country_id = $data['country_id'];


            $place->save();

            return $this->_response($place);
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

            $places = $this->model::where(function ($q) use ($request) {
                if ($request->has('type')) {
                    $q->where('type', $request->type);
                }
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%");
                }
            })->take(10)
                ->get();

            foreach ($places as $place) {

                $obj = new \stdClass();
                $obj->id = $place->id;
                $name = Helper::getFullNamePlace($place); // helper Static function to return place name with parents names
                $obj->name = $name;
                $obj->text = $name; // text field used in select2

                $result[] = $obj;
            }

            return response()->json($result);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
}
