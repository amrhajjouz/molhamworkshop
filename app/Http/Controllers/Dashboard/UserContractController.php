<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContract\{CreateUserContractRequest, UpdateUserContractRequest};
use App\Models\UserContract;
use App\Models\User;
use Illuminate\Http\Request;

class UserContractController extends Controller
{

    public function create(CreateUserContractRequest $request)
    {
        $oldContract = UserContract::where('user_id', $request->user_id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('contract_start_date', [$request->contract_start_date, $request->contract_end_date])
                    ->orWhereDate('contract_start_date', '>=', $request->contract_start_date)
                    ->orWhereBetween('contract_end_date', [$request->contract_start_date, $request->contract_end_date])
                    ->orWhereDate('contract_end_date', '>=', $request->contract_end_date);
            })->get();
        if (count($oldContract) > 0) {
            return response(['error' => 'user has active contact'], 500);
        }
        try {
            //dd($request->all());

            $user_contract = UserContract::create($request->validated());
            userExperienceCount($request->user_id, $request->contract_start_date, $request->contract_end_date);
            return response()->json($user_contract);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateUserContractRequest $request)
    {
        try {
            $user_contract = UserContract::findOrFail($request->id);
            $user_contract->update($request->validated());
            return response()->json($user_contract);
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(UserContract::with(['user', 'office', 'jobTitle', 'userSection', 'supervisor'])->where('id', $id)->firstOrFail());
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function members(Request $request)
    {
        try {
            $users = User::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('first_name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('first_name->en', 'like', "%" . $request->q . "%");
                    $q->orWhere('last_name->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('last_name->en', 'like', "%" . $request->q . "%");
                }
            })->take(10)->get()->map(function ($user) {
                return ['id' => $user->id, 'text' => $user->first_name[app()->getLocale()] . ' ' . $user->last_name[app()->getLocale()]];
            });
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list(Request $request)
    {
        try {
            return response()->json(UserContract::with('user')->orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('contract_type', 'like', '%' . $request->q . '%');
                    //$q->orWhere('first_name->ar', 'like', '%' . $request->q . '%');
                    //$q->orWhere('first_name->en', 'like', '%' . $request->q . '%');
                    //$q->orWhere('last_name->ar', 'like', '%' . $request->q . '%');
                    //$q->orWhere('last_name->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
