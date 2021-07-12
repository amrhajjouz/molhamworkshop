<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

use App\Models\User;

class UserController extends Controller {
    
    public function __construct () {
        $this->middleware('auth');
    }
    public function create (CreateUserRequest $request) {
        
        try {
            
            // Create User
            $user = User::create($request->validated());
            
            return response()->json($user);
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function update (UpdateUserRequest $request) {
        
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
    
      /////////////////////// Attachments /////////////////////////

      public function listing_attachments(Request $request, User $user)
      {
          try {
              return response()->json($user->files);
          } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];

          }
      }
}