<?php

namespace App\Http\Controllers;

use App\Models\{Permission, Role, User};
use App\Http\Requests\Role\{
    CreateRoleRequest,
    UpdateRoleRequest,
    UnassignPermissionRequest,
    AssignPermissionRequest,
    RetrieveRoleRequest,
    ListRoleRequest,
    ListRolePermissionsRequest,
    SearchRoleRequest,
};

class RoleController extends Controller
{
    public function create(CreateRoleRequest $request)
    {
        try {
            $data = $request->validated();
            $role = Role::create($data);
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateRoleRequest $request)
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

    public function retrieve(RetrieveRoleRequest $request, $id)
    {
        try {
            return response()->json(Role::findOrFail($id)->transform());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(ListRoleRequest $request)
    {
        try {
            $roles = Role::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                    $q->orWhere('title->ar', 'like', '%' . $request->q . '%');
                    $q->orWhere('title->en', 'like', '%' . $request->q . '%');
                }
            })->paginate(5)->withQueryString();
            return response()->json($roles);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list_permissions(ListRolePermissionsRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $permissions = $role->permissions;
            return response()->json($permissions);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function unassign_permissions(UnassignPermissionRequest $request, Role $role)
    {
        try {
            $data = $request->validated();
            $permission = Permission::findORfail($data['permission_id']);
            if ($role->hasPermissionTo($permission->name)) $role->revokePermissionTo($permission->name);
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function assign_permissions(AssignPermissionRequest $request, Role $role)
    {
        try {
            $data = $request->validated();
            foreach ($data['permissions_ids'] as $key => $value) {
                $permission = Permission::findORfail($value);
                $role->givePermissionTo($permission->name);
            }
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function search (SearchRoleRequest $request)
    {
        try {
            $results = [];
            $data = Role::where('id', '>', 1)->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%");
                    $q->orWhere('title->ar', 'like', "%" . $request->q . "%");
                    $q->orWhere('title->en', 'like', "%" . $request->q . "%");
                }
            })
            ->where(function ($q) use ($request) {
                //except permissions already assigned to this user
                if ($request->has('user_id')) {
                    $user = User::find($request->user_id);
                    if ($user) {
                        $q->whereNotIn('id', $user->roles()->pluck('id'));
                    }
                }
            })
            ->take(10)->get();
            $locale = app()->getLocale();
            foreach ($data as $r) {
                $results[] = ['id' => $r['id'], 'text' => $r['title'][$locale]];
            }
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
