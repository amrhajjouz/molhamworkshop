<?php

namespace App\Http\Controllers;

use App\Models\{Permission, Role, User};
use App\Http\Requests\Permission\{CreatePermissionRequest, UpdatePermissionRequest, RetrievePermissionRequest, ListPermissionRequest, SearchPermissionRequest};

class PermissionController extends Controller
{

    public function create(CreatePermissionRequest $request)
    {
        try {
            $data = $request->validated();
            $role = Permission::create($data);
            return response()->json($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdatePermissionRequest $request)
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

    public function retrieve(RetrievePermissionRequest $request, $id)
    {
        try {
            return response()->json(Permission::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(ListPermissionRequest $request)
    {
        try {
            $permissions = Permission::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                    $q->orWhere('description_ar', 'like', '%' . $request->q . '%');
                }
            })->paginate(5)->withQueryString();
            return response()->json($permissions);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function search(SearchPermissionRequest $request)
    {
        try {
            $results = [];
            $data = Permission::where('id', '>', 1)
                ->where(function ($q) use ($request) {
                    if ($request->has('q')) {
                        $q->where('name', 'like', "%" . $request->q . "%");
                        $q->orWhere('description_ar', 'like', "%" . $request->q . "%");
                        $q->orWhere('description_en', 'like', "%" . $request->q . "%");
                    }
                })
                ->where(function ($q) use ($request) {
                    //except permissions already assigned to this role
                    if ($request->has('role_id')) {
                        $role = Role::find($request->role_id);
                        if ($role) {
                            $q->whereNotIn('id', $role->permissions()->pluck('permission_id'));
                        }
                    }
                })
                ->where(function ($q) use ($request) {
                    //except permissions already assigned to this user
                    if ($request->has('user_id')) {
                        $user = User::find($request->user_id);
                        if ($user) {
                            $q->whereNotIn('id', $user->getDirectPermissions()->pluck('id'));
                        }
                    }
                })->take(10)->get();
            $locale = app()->getLocale();
            foreach ($data as $p){$results[] = ['id' => $p['id'], 'text' => $p['description_' . $locale]];}
            return response()->json($results);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }
}
