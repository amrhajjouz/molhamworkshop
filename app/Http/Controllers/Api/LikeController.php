<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Like\{CreateLikeRequest , DeleteLikeRequest};

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_donor');
    }

    public function create(CreateLikeRequest $request)
    {
        try {
            authDonor()->likes()->firstOrCreate($request->validated());
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(DeleteLikeRequest $request, $id)
    {
        try {
            authDonor()->likes()->where('id',$id)->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
