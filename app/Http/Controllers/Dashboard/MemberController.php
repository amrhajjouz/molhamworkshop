<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Member\{CreateMemberRequest, UpdateMemberRequest};
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateMemberRequest $request) {

        try {
            $user = User::create($request->validated());

            return response()->json($user);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update (UpdateMemberRequest $request) {

        try {

            // Fetch User
            $user = User::findOrFail($request->id);

            // Update User
            //dd($request->all());
            $user->update($request->validated());

            return response()->json($user);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve ($id) {

        try {

            // Fetch User and Return
            return response()->json(User::findOrFail($id));

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list (Request $request) {

        try {

            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $users = User::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();

            return response()->json($users);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete($id){
        try {
            $member =  User::find($id)->delete();
            return response()->json($member);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
