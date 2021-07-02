<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Event\{CreateRequest , UpdateRequest};
use App\Models\Event;

class EventController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            return response()->json(Event::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $activity = Event::findOrFail($request->id);
            $activity->update($request->validated());
            return response()->json($activity);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(Event::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $activities = Event::orderBy('id', 'desc')->where(function($q) use($request){
                if($request->has('q')){
                    $q->where('name', 'like', '%' . $request->q . '%');
                    $q->orWhere('body_ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('body_en', 'like', '%' . $request->q . '%');
                }
            })->paginate(5)->withQueryString();
            return response()->json($activities);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
 