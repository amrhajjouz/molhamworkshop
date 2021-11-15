<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFamilyMember\{CreateUserFamilyMemberRequest, UpdateUserFamilyMemberRequest};
use App\Models\UserFamilyMember;


class UserFamilyMemberController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateUserFamilyMemberRequest $request) {
        try {
            $userFamilyMember = UserFamilyMember::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

            return response()->json($userFamilyMember);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserFamilyMemberRequest $request) {
        try {
            $userFamilyMember = UserFamilyMember::findOrFail($request->id);

            $userFamilyMember->update($request->validated());

            return response()->json($userFamilyMember);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(UserFamilyMember::findOrFail($id));
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {
            $userFamilyMembers = UserFamilyMember::orderBy('id', 'desc')->paginate(5);

            return response()->json($userFamilyMembers);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $userFamilyMembers =  UserFamilyMember::find($id)->delete();
            return response()->json($userFamilyMembers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
