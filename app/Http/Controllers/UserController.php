<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Arr;

use App;

class UserController extends Controller {
    
    public function __construct () {
        $this->middleware('auth');
    }
    
    public function store (StoreUserRequest $request) {
        
        try {
            sleep(2);
            $data = $request->validated();            
            
            if ($request->has('id')) {
                $user = App\User::findOrFail($data['id']);
                $user->update(Arr::except($data, ['id']));
            } else {
                $user = App\User::create($data);
            }
            
            return response()->json($user);
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function retrieve ($id) {
        
        try {
            
            return App\User::findOrFail($id);            
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}