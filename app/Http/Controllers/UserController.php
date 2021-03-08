<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\StoreUserRequest;

use App\Models\User;

class UserController extends Controller {
    
    public function __construct () {
        $this->middleware('auth');
    }
    
    public function store (StoreUserRequest $request) {
        
        try {
            
            $data = $request->validated();            
            
            if ($request->has('id')) {
                $user = User::findOrFail($data['id']);
                $user->update($request->except('id'));
            } else {
                $user = User::create($data);
            }
            
            return response()->json($user);
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function retrieve ($id) {
        
        try {
            
            return User::findOrFail($id);            
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function list (Request $request) {
        
        try {
            
            return User::all();            
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}