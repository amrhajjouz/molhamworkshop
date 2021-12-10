<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\UserContract;
use App\Models\UserSection;
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
            return response()->json(User::create($request->validated()));

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update (UpdateMemberRequest $request) {

        try {
            $user = User::findOrFail($request->id);

            $user->update($request->validated());

            return response()->json($user);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function user_sections(Request $request)
    {
        try {
            $users = UserSection::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('section_name', 'like', "%" . $request->q . "%");
                    //$q->orWhere('first_name.en', 'like', "%" . $request->q . "%");
                    //$q->orWhere('fullname->ar', 'like', "%" . $request->q . "%");
                    //$q->orWhere('fullname->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function ($user) {
                return ['id' => $user->id, 'text' => $user->section_name];
            });
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function retrieve ($id) {
        try {
            return response()->json(User::findOrFail($id));

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function contracts ($id) {
        try {
            $user_contracts = UserContract::with('user')->where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

            //dd($userContracts);
            return response()->json($user_contracts);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request) {

        try {

            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);

            $users = User::orderBy('id', 'asc')->where($search_query)->paginate(5)->withQueryString();

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
