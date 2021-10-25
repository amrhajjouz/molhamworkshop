<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(CreateUserRequest $request)
    {

        try {
            // Create User
            $user = User::create($request->validated());

            return response()->json($user);

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateUserRequest $request)
    {

        try {
            // Fetch User
            $user = User::findOrFail($request->id);

            // Update User
            $user->update($request->validated());

            return response()->json($user);

        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function retrieve($id)
    {

        try {

            // Fetch User and Return
            return response()->json(User::findOrFail($id));

        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {

        try {

            $users = User::orderBy('id', 'desc')->SearchByName(request()->q)->paginate(5)->withQueryString();

            return response()->json($users);

        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search()
    {
        try {
            $donors = User::searchByName(request()->q)
                ->select("name", "id", "email")
                ->get()
                ->map(function ($donor) {
                    return [
                        "id" => $donor->id,
                        "text" => "{$donor->name} - {$donor->email} - [ {$donor->id} ]"
                    ];
                });
            return response()->json($donors);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

}
