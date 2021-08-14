<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApiError\{CreateApiErrorRequest , UpdateApiErrorRequest};
use App\Models\ApiError;

class ApiErrorController extends Controller
{
    public function create(CreateApiErrorRequest $request)
    {
        try {
            return response()->json(ApiError::create($request->validated()));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateApiErrorRequest $request)
    {
        try {
            $data = $request->validated();
            $apiError = ApiError::findOrFail($data['id']);
            $apiError->update($data);
            return response()->json($apiError);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(ApiError::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            return response()->json(ApiError::orderBy('id', 'desc')->where(function($q) use ($request){
                if($request->has('q')){
                    $q->where('code', 'like', '%' . $request->q . '%');
                    $q->orWhere('status', 'like', '%' . $request->q . '%');
                    $q->orWhere('message->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('message->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(5)->withQueryString());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
