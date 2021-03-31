<?php

namespace App\Http\Controllers;

use App\Common\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

use App\Models\User;

class UserController extends BaseController {
    
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
            
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            
            $users = User::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            
            return response()->json($users);  
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function search(Request $request)
    {

        try {

            $result = [];
            $data = null;

            $data = User::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%")
                        ->orWhere('email', 'like', "%" . $request->q . "%");
                }
            })
                ->take(10)
                ->get();

            foreach ($data as $item) {

                $obj = new \stdClass();
                $obj->id = $item->id;
                $obj->name = $item->name;
                $obj->text = $item->name;

                $result[] = $obj;
            }

            return response()->json($result);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
    
}