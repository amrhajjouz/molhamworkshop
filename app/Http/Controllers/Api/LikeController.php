<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Like\{CreateLikeRequest , DislikeRequest};
use App\Models\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }

    public function create(CreateLikeRequest $request)
    {
        try {
            $data = array_merge($request->validated() , ['liker_id' => authDonor()->id , 'liker_type' => 'donor']);
            Like::firstOrCreate($data);
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function dislike(DislikeRequest $request)
    {
        try {
            $data = $request->validated();
            Like::where(['likeable_type' => $data['likeable_type'] , 'likeable_id' => $data['likeable_id'] , 'liker_type' => 'donor' , 'liker_id' => authDonor()->id])->firstOrFail()->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
