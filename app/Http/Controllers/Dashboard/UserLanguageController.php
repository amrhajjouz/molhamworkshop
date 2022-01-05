<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLanguage\{CreateUserLanguageRequest, UpdateUserLanguageRequest,ListUserLanguageRequest,DeleteUserLanguageRequest,RetrieveUserLanguageRequest};
use App\Models\UserLanguage;

class UserLanguageController extends Controller {

    public function create (CreateUserLanguageRequest $request) {
        try {
            $userLanguage = UserLanguage::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

            return response()->json($userLanguage);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserLanguageRequest $request) {
        try {
            $userLanguage = UserLanguage::findOrFail($request->id);

            $userLanguage->update($request->validated());

            return response()->json($userLanguage);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserLanguage::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list () {

        try {
            $user_languages = UserLanguage::where('user_id', auth()->id())->orderBy('id', 'asc')->paginate(5);
            return response()->json($user_languages);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
