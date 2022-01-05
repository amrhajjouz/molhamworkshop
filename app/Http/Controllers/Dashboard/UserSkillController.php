<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSkill\{CreateUserSkillRequest, UpdateUserSkillRequest,ListUserSkillRequest,DeleteUserSkillRequest,RetrieveUserSkillRequest};
use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller {

    public function create (CreateUserSkillRequest $request) {
        try {
            $user_skill = UserSkill::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
            return response()->json($user_skill);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserSkillRequest $request) {
        try {
            $user_skill = UserSkill::findOrFail($request->id);

            $user_skill->update($request->validated());

            return response()->json($user_skill);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserSkill::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list () {

        try {
            $user_skills = UserSkill::where('user_id', auth()->id())->orderBy('id', 'asc')->paginate(5);
            return response()->json($user_skills);


        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
