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
            $user_family_member = UserFamilyMember::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

            return response()->json($user_family_member);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update (UpdateUserFamilyMemberRequest $request) {
        try {
            $user_family_member = UserFamilyMember::findOrFail($request->id);

            $user_family_member->update($request->validated());

            return response()->json($user_family_member);
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
            $user_family_members = UserFamilyMember::where('user_id', auth()->id())->orderBy('id', 'asc')->paginate(5);

            return response()->json($user_family_members);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $user_family_member =  UserFamilyMember::find($id)->delete();
            return response()->json($user_family_member);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
