<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserWorkExperience\{CreateUserWorkExperienceRequest, UpdateUserWorkExperienceRequest,ListUserWorkExperienceRequest,DeleteUserWorkExperienceRequest,RetrieveUserWorkExperienceRequest};
use App\Models\UserWorkExperience;
use Illuminate\Http\Request;

class UserWorkExperienceController extends Controller {

    public function create (CreateUserWorkExperienceRequest $request) {
        try {
            $user_work_experience = UserWorkExperience::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
            return response()->json($user_work_experience);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserWorkExperienceRequest $request) {
        try {
            $user_work_experience = UserWorkExperience::findOrFail($request->id);

            $user_work_experience->update($request->validated());

            return response()->json($user_work_experience);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserWorkExperience::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {
            $user_work_experiences = UserWorkExperience::where('user_id', auth()->id())->orderBy('id', 'asc')->paginate(5);

            return response()->json($user_work_experiences);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
