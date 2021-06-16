<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\{UpdateUserRequest, ListUserRolesRequest, AssignRolesRequest, UnAssignRoleRequest, AssignPermissionRequest, UnassignPermissionRequest};
use App\Models\{User, Role, Permission};

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

            // Fetch User and Return
            return response()->json(User::findOrFail($id));
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


    public function list_roles(ListUserRolesRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            $roles = $user->roles;

            return response()->json($roles);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function assign_roles(AssignRolesRequest $request, $user_id)
    {
        try {
            $data = $request->validated();

            $user = User::findOrFail($user_id);

            foreach ($data['role_ids'] as $key => $value) {
                $role = Role::findORfail($value);
                if ($user->hasRole($role->name)) {
                    continue;
                }

                $user->assignRole($role->name);
            }


            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function unassign_role(UnAssignRoleRequest $request, $user_id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrfail($user_id);
            $role = Role::findOrfail($data['role_id']);

            if ($user->hasRole($role->name)) {
                $user->removeRole($role->name);
            }

            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function list_permissions(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $permissions = $user->getDirectPermissions();

            return response()->json($permissions);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unassign_permission(UnassignPermissionRequest $request,$id)
    {
        try {


            $data = $request->validated();
            $user = User::findOrFail($id);
            $permission = Permission::findORfail($data['permission_id']);

            if ($user->hasDirectPermission($permission->name)) {
                $user->revokePermissionTo($permission->name);
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function assign_permissions(AssignPermissionRequest $request, $id)
    {
        try {


            $data = $request->validated();

            $user = User::findOrFail($id);

            foreach ($data['permission_ids'] as $key => $value) {
                $permission = Permission::findORfail($value);
                if ($user->hasDirectPermission($permission->name)) {
                    continue;
                }
                $user->givePermissionTo($permission->name);
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
