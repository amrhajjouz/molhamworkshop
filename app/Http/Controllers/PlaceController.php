<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Place\{CreatePlaceRequest, UpdatePlaceRequest};
use App\Models\{Place};
use App\Facades\Helper;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->model = \App\Models\Place::class;
    }

    public function create(CreatePlaceRequest $request)
    {
        try {
            return response()->json(Place::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdatePlaceRequest $request)
    {
        try {
            $data = $request->validated();
            $place = $this->model::findOrFail($request->id);
            $place->update($data);
            return response()->json($place);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            $places = Place::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString();
            foreach ($places  as $place) {$place->long_name = Helper::getFullNamePlace($place);}
            return response()->json($places);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
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
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(Place::findOrFail($id)->transform());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
