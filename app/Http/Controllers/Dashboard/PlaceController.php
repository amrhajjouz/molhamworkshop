<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests\Place\{CreatePlaceRequest, UpdatePlaceRequest};
use App\Models\{Place};
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{

    public function create(CreatePlaceRequest $request)
    {
        try {
            return response()->json(Place::create($request->validated()));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
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
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list(Request $request)
    {
        try {
            return response()->json(Place::orderBy('id', 'desc')->where(function($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('name->en', 'like', '%' . $request->q . '%');
                    $q->orWhere('fullname->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('fullname->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        try {
            $places = Place::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('name->en', 'like', "%" . $request->q . "%");
                    //$q->orWhere('fullname->ar', 'like', "%" . $request->q . "%");
                    //$q->orWhere('fullname->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function($place) {
                return  ['id'=> $place->id, 'text' => $place->fullname[app()->getLocale()]]; 
            });
            return response()->json($places);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function retrieve($id)
    {
        try {
            $place = Place::with(['parent', 'country'])->where('id', $id)->firstOrFail();
            return response()->json($place);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
