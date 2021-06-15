<?php

namespace App\Http\Controllers;

  use App\Models\{Permission , Role};
 use Illuminate\Http\Request;
 use App\Http\Requests\Permission\{CreatePermissionRequest , UpdatePermissionRequest};
 use Illuminate\Support\Facades\Hash;

 class PermissionController extends Controller
{

    public function create (CreatePermissionRequest $request)
    {
        try {
            $data = $request->validated();
            $role = Permission::create($data);
            return response()->json($role);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update (UpdatePermissionRequest $request)
    {
        try {
            $role = Permission::findOrFail($request->id);
            $data = $request->validated();

            $role->update($data);
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve ($id)
    {
        try {
            return response()->json(Permission::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list (Request $request) {
        

        
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            
            $permissions = Permission::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            
            return response()->json($permissions);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
