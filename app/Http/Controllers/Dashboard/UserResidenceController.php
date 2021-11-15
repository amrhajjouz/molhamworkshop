<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserResidence\{CreateUserResidenceRequest, UpdateUserResidenceRequest,ListUserResidenceRequest,DeleteUserResidenceRequest,RetrieveUserResidenceRequest};
use App\Models\UserResidence;

class UserResidenceController extends Controller {

    public function create (CreateUserResidenceRequest $request) {
        try {
            $userResidence = UserResidence::create($request->validated());

            return response()->json($userResidence);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserResidenceRequest $request) {
        try {
            $userResidence = UserResidence::findOrFail($request->id);

            $userResidence->update($request->validated());

            return response()->json($userResidence);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveUserResidenceRequest $request) {
        try {
            return response()->json(UserResidence::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListUserResidenceRequest $request) {

        try {
            $userResidences = UserResidence::orderBy('id', 'desc')->paginate(5);

            return response()->json($userResidences);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
