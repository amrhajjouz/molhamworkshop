<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContract\{CreateUserContractRequest, UpdateUserContractRequest};
use App\Models\UserContract;
use Illuminate\Http\Request;

class UserContractController extends Controller {

    public function create (CreateUserContractRequest $request) {
        try {
            $userContract = UserContract::create($request->validated());

            return response()->json($userContract);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserContractRequest $request) {
        try {
            $userContract = UserContract::findOrFail($request->id);

            $userContract->update($request->validated());

            return response()->json($userContract);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserContract::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {
            $userContracts = UserContract::orderBy('id', 'desc')->paginate(5);

            return response()->json($userContracts);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
