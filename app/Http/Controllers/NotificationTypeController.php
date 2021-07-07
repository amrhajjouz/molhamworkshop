<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationType\{CreateRequest , UpdateRequest};
use App\Models\NotificationType;

class NotificationTypeController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            return response()->json(NotificationType::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $activity = NotificationType::findOrFail($request->id);
            $activity->update($request->validated());
            return response()->json($activity);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function retrieve($id)
    {
        try {
            return response()->json(NotificationType::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $activities = NotificationType::orderBy('id', 'desc')->where(function($q) use($request){
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
 