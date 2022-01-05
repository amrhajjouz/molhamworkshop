<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Leave;
use App\Models\UserContract;
use App\Models\UserFamilyMember;
use App\Models\UserLanguage;
use App\Models\UserSection;
use App\Models\UserSkill;
use App\Models\UserTraining;
use App\Models\UserWorkExperience;
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


            return response()->json($user_contracts);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function user_family_member ($id) {
        try {
            $user_family_members = UserFamilyMember::with('user')->where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

            return response()->json($user_family_members);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function user_work_experiences ($id) {
        try {
            $user_work_experiences = UserWorkExperience::with('user')->where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

            return response()->json($user_work_experiences);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function user_skills ($id) {
        try {
            $user_skills = UserSkill::where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

            return response()->json($user_skills);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function user_languages ($id) {
        try {
            $user_languages = UserLanguage::where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

            return response()->json($user_languages);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function user_trainings ($id) {
        try {
            $user_trainings = UserTraining::where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

            return response()->json($user_trainings);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function info ($id) {
        try {
            $user = User::with(['currentCountry', 'currentCity', 'country'])->where('id', $id)->orderBy('id', 'desc')->paginate(5);

            return response()->json($user);

        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list (Request $request)
    {
        try {
            return response()->json(User::orderBy('id', 'asc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                    $q->orWhere('first_name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('first_name->en', 'like', '%' . $request->q . '%');
                    $q->orWhere('last_name->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('last_name->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
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
