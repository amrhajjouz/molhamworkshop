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
            $user->eventLogs()->create(["event_name" => "add_user", 'activity_name' => "add_user",]);
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
            $user->eventLogs()->create(["event_name" => "update_user"]);
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

    public function listRoles(ListUserRolesRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $roles = $user->roles;
            return response()->json($roles);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function assignRoles(AssignRolesRequest $request, $user_id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrFail($user_id);
            foreach ($data['roles_ids'] as $key => $value) {
                $role = Role::findORfail($value);
                if ($user->hasRole($role->name)) continue;
                $user->assignRole($role->name);
                $user->activityLogs()->create(["activity_name" => "assign_role", 'metadata' => ['role_ar' => $role->description_ar, 'role_en' => $role->description_en]]);
                $user->eventLogs()->create(["event_name" => "assign_role", 'activity_name' => "assign_role", 'metadata' => ['role_ar' => $role->description_ar, 'role_en' => $role->description_en]]);
            }
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unassignRole(UnassignRoleRequest $request, $user_id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrfail($user_id);
            $role = Role::findOrfail($data['role_id']);
            if ($user->hasRole($role->name)) {
                $user->removeRole($role->name);
                $user->activityLogs()->create(["activity_name" => "unassign_role", 'metadata' => ['role_ar' => $role->description_ar, 'role_en' => $role->description_en]]);
                $user->eventLogs()->create(["event_name" => "unassign_role", 'activity_name' => "unassign_role", 'metadata' => ['role_ar' => $role->description_ar, 'role_en' => $role->description_en]]);
            }
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listPermissions(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user->getDirectPermissions());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unassignPermission(UnassignPermissionRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);
            $permission = Permission::findORfail($data['permission_id']);
            if ($user->hasDirectPermission($permission->name)) $user->revokePermissionTo($permission->name);
            $user->activityLogs()->create(["activity_name" => "unassign_permission", 'metadata' => ['permission_ar' => $permission->description_ar, 'permission_en' => $permission->description_en]]);
            $user->eventLogs()->create(["event_name" => "unassign_permission", 'activity_name' => "unassign_permission", 'metadata' => ['permission_ar' => $permission->description_ar, 'permission_en' => $permission->description_en]]);
            return response()->json($user);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function assignPermissions(AssignPermissionRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $user = User::findOrFail($id);
            foreach ($data['permissions_ids'] as $key => $value) {
                $permission = Permission::findORfail($value);
                if ($user->hasDirectPermission($permission->name)) continue;
                $user->givePermissionTo($permission->name);
                $user->activityLogs()->create(["activity_name" => "assign_permission", 'metadata' => ['permission_ar' => $permission->description_ar, 'permission_en' => $permission->description_en]]);
                $user->eventLogs()->create(["event_name" => "assign_permission", 'activity_name' => "assign_permission", 'metadata' => ['permission_ar' => $permission->description_ar, 'permission_en' => $permission->description_en]]);
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

    public function listEventLogs(Request $request, User $user)
    {
        try {
            $events = $user->eventLogs()
                ->join('events AS EV', 'event_logs.event_id', 'EV.id')
                // ->leftJoin('activities AS AC', 'event_logs.activity_id', 'AC.id')
                ->select('event_logs.*', 'EV.name AS event_name')
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', '%' . $request->q . '%');
                        $q->orWhere('EV.name', 'like', '%' . $request->q . '%');
                        // $q->orWhere('AC.name', 'like', '%' . $request->q . '%');
                    }
                })->paginate(5)->withQueryString();
            return response()->json($events);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
