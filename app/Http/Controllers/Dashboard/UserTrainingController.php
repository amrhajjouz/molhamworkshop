<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTraining\{CreateUserTrainingRequest, UpdateUserTrainingRequest,ListUserTrainingRequest,DeleteUserTrainingRequest,RetrieveUserTrainingRequest};
use App\Models\UserTraining;
use Illuminate\Http\Request;

class UserTrainingController extends Controller {

    public function create (CreateUserTrainingRequest $request) {
        try {
            $user_trainings = UserTraining::create(array_merge($request->validated(), ['user_id' => auth()->id()]));
            return response()->json($user_trainings);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserTrainingRequest $request) {
        try {
            $user_trainings = UserTraining::findOrFail($request->id);
            $user_trainings->update($request->validated());

            return response()->json($user_trainings);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserTraining::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list () {

        try {
            $user_trainings = UserTraining::where('user_id', auth()->id())->orderBy('id', 'asc')->paginate(5);
            return response()->json($user_trainings);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }
}
