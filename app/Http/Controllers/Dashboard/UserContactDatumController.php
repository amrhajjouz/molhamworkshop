<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContactDatum\{CreateUserContactDatumRequest, UpdateUserContactDatumRequest,ListUserContactDatumRequest,DeleteUserContactDatumRequest,RetrieveUserContactDatumRequest};
use App\Models\UserContactDatum;

class UserContactDatumController extends Controller {

    public function create (CreateUserContactDatumRequest $request) {
        try {
            $userContactDatum = UserContactDatum::create($request->validated());

            return response()->json($userContactDatum);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserContactDatumRequest $request) {
        try {
            $userContactDatum = UserContactDatum::findOrFail($request->id);

            $userContactDatum->update($request->validated());

            return response()->json($userContactDatum);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveUserContactDatumRequest $request) {
        try {
            return response()->json(UserContactDatum::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListUserContactDatumRequest $request) {

        try {
            $userContactData = UserContactDatum::orderBy('id', 'desc')->paginate(5);

            return response()->json($userContactData);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
