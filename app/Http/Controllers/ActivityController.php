<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Activity\{CreateActivityRequest , UpdateActivityRequest};
use App\Models\Activity;

class ActivityController extends Controller
{

    public function create(CreateActivityRequest $request)
    {
        try {
            return response()->json(Activity::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateActivityRequest $request)
    {
        try {
            $activity = Activity::findOrFail($request->id);
            $data = $request->validated();
            $activity->update($data);
            return response()->json($activity);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(Activity::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $activities = Activity::orderBy('id', 'desc')->where(function($q) use($request){
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
