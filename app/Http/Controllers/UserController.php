<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\{UpdateUserRequest, ListUserRolesRequest, AssignRolesRequest, UnassignRoleRequest, AssignPermissionRequest, UnassignPermissionRequest};
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
            $user->activityLogs()->create(["activity_name" => "create_user"]);
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
            $user->update($request->validated());
            $user->activityLogs()->create(["activity_name" => "update_user"]);

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
            foreach ($data['roles_ids'] as $key => $value) {
                $role = Role::findORfail($value);
                if ($user->hasRole($role->name)) continue;
                $user->assignRole($role->name);
                $user->activityLogs()->create(["activity_name" => "assign_role", 'metadata' => ['role' => $role->toArray()['description_' . app()->getLocale()]]]);
            }
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unassign_role(UnassignRoleRequest $request, $user_id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrfail($user_id);
            $role = Role::findOrfail($data['role_id']);
            if ($user->hasRole($role->name)) {
                $user->removeRole($role->name);
                $user->activityLogs()->create(["activity_name" => "unassign_role", 'metadata' => ['role' => $role->toArray()['description_' . app()->getLocale()]]]);
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
            return response()->json($user->getDirectPermissions());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unassign_permission(UnassignPermissionRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);
            $permission = Permission::findORfail($data['permission_id']);
            if ($user->hasDirectPermission($permission->name)) $user->revokePermissionTo($permission->name);
            $user->activityLogs()->create(["activity_name" => "unassign_permission" , 'metadata'=>['permission'=>$permission->toArray()['description_'.app()->getLocale()]]]);
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
            foreach ($data['permissions_ids'] as $key => $value) {
                $permission = Permission::findORfail($value);
                if ($user->hasDirectPermission($permission->name)) continue;
                $user->givePermissionTo($permission->name);
                $user->activityLogs()->create(["activity_name" => "assign_permission", 'metadata' => ['permission' => $permission->toArray()['description_' . app()->getLocale()]]]);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listActivityLogs(Request $request, User $user)
    {
        try {
            $logs = $user->activityLogs()
                ->with(['actor'])
                ->join('activities AS A', 'activity_logs.activity_id', 'A.id')
                ->select('activity_logs.*', 'A.name AS activity_name')
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', '%' . $request->q . '%');
                        $q->orWhere('actor_type', 'like', '%' . $request->q . '%');
                        $q->orWhere('A.name', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();
            return response()->json($logs);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listActivities(Request $request, User $user)
    {
        try {
            $activities = $user->activities()
                ->join('activities AS A', 'activity_logs.activity_id', 'A.id')
                ->select('activity_logs.*', 'A.name AS activity_name')
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', '%' . $request->q . '%');
                        $q->orWhere('actor_type', 'like', '%' . $request->q . '%');
                        $q->orWhere('A.name', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();
            return response()->json($activities);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
