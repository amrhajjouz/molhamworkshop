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
            
            $data = $request->all();
            // Create User
            $user = User::create($data);
            
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
            
            return response()->json(User::all());            
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}