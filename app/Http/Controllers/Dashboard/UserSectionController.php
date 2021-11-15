<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSection\{CreateUserSectionRequest, UpdateUserSectionRequest,ListUserSectionRequest,DeleteUserSectionRequest,RetrieveUserSectionRequest};
use App\Models\UserSection;

class UserSectionController extends Controller {

    public function create (CreateUserSectionRequest $request) {
        try {
            $userSection = UserSection::create($request->validated());

            return response()->json($userSection);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserSectionRequest $request) {
        try {
            $userSection = UserSection::findOrFail($request->id);

            $userSection->update($request->validated());

            return response()->json($userSection);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id, RetrieveUserSectionRequest $request) {
        try {
            return response()->json(UserSection::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (ListUserSectionRequest $request) {

        try {
            $userSections = UserSection::orderBy('id', 'desc')->paginate(5);

            return response()->json($userSections);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
