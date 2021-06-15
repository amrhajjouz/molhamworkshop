<?php

namespace App\Http\Controllers;

  use App\Models\{Donor , Permission, Role};
 use Illuminate\Http\Request;
 use App\Http\Requests\Role\{CreateRoleRequest , UpdateRoleRequest , UnassignPermissionRequest};
 use Illuminate\Support\Facades\Hash;

 class RoleController extends Controller
{

    public function create (CreateRoleRequest $request)
    {
        try {
            $data = $request->validated();
            $role = Role::create($data);
            return response()->json($role);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update (UpdateRoleRequest $request)
    {
        try {
            $role = Role::findOrFail($request->id);
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
            return response()->json(Role::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list (Request $request) {
        

        
        try {
            $search_query = ($request->has('q') ? [['name', 'like', '%' . $request->q . '%']] : null);
            
            $roles = Role::orderBy('id', 'desc')->where($search_query)->paginate(5)->withQueryString();
            
            return response()->json($roles);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list_permissions (Request $request , $id) {
        try {
            $role = Role::findOrFail($id);
            
            $permissions = $role->permissions;
            
            return response()->json($permissions);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    
    public function unassign_permissions (UnassignPermissionRequest $request , Role $role) {
        try {
            $data = $request->validated();
            $permission = Permission::findORfail($data['permission_id']);

            if($role->hasPermissionTo($permission->name)){
                $role->revokePermissionTo($permission->name);
            }

            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
