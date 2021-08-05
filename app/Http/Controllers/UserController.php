<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(CreateUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return response()->json($user);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            $user = User::findOrFail($id);
            // $user->unreadNotifications->markAsRead();
            // dd($user->unreadNotifications);

            //THis way to send notification we have to pass variable in data array

            // $user->notifications()->create(
            //     [
            //     "name" => "update_user",
            //     'data' => [
            //         // 'id' =>"$user->id", 
            //         'id' =>"2", 
            //         'user_id' => "$user->id", 
            //         // 'viewer_name' => $user->name, 
            //         'creator_name' => auth()->user()->name, 
            //         'name' => "naaaaame", 
            //         // 'date' => date('Y-dd-mm H:i:s' , time() ), 
            //         'user_lang' => $user->lang ?? "ar", 
            //     ]
            // ]);
            // Fetch User and Return
            return response()->json($user);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            $users = User::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            return response()->json($users);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function listNotifications(Request $request, User $user)
    {
        try {
            $notifications = $user->notifications()
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('type', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();
            return response()->json($notifications);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
