<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Place\{CreatePlaceRequest, UpdatePlaceRequest};
use App\Models\{Place};

class PlaceController extends Controller
{

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
            $place = Place::findOrFail($request->id);
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
            return response()->json(Place::orderBy('id', 'desc')->where($search_query)->paginate(10)->withQueryString()->through(function ($place) {
                $place->long_name = $place->getFullNamePlace();
                return $place;
            }));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function search(Request $request)
    {
        try {
            $result = [];
            $places = Place::where(function ($q) use ($request) {
                if ($request->has('type')) $q->where('type', $request->type);
                if ($request->has('q')) $q->where('name', 'like', "%" . $request->q . "%");
            })->take(10)->get();
            foreach ($places as $place) {
                $obj = new \stdClass();
                $obj->id = $place->id;
                $name = $place->getFullNamePlace();
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
            $place = Place::findOrFail($id);
            $parent = $place->parent;
            $country = $place->country;
            if ($country) $country->name = json_decode($country->name);
            if ($parent) {
                $parent->parent;
            }
            return  response()->json(array_merge($place->toArray(), [
                'parent' => $parent,
                'country' => $country ? ['name' => $country->name["ar"]] : null
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
