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
            return response()->json(Place::orderBy('id', 'desc')->where(function($q) use ($request){
                if($request->has('q')){
                    $q->where('name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('name->en', 'like', '%' . $request->q . '%');
                    $q->orWhere('fullname->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('fullname->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString()->through(function ($place) {
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
            $places = Place::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('name->en', 'like', "%" . $request->q . "%");
                    $q->orWhere('fullname->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('fullname->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function($place){
                $locale = app()->getLocale();
                return  ['id'=>$place->id , 'name'=>$place->name[$locale] , 'text'=>$place->name[$locale]]; });
            return response()->json($places);
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
            $locale = app()->getLocale();

            if ($parent) {
                $parent->parent;
            }
            return  response()->json(array_merge($place->toArray(), [
                'parent' => $parent ? [
                    'id' => $parent->id , 
                    'name' => $parent->name[$locale] ,
                ]:null,
                'country' => $country ? ['name' => $country->name[$locale]] : null
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
