<?php

namespace App\Http\Controllers;

use App\Models\{Permission, Role, User};
use Illuminate\Http\Request;
use App\Http\Requests\Permission\{CreatePermissionRequest, UpdatePermissionRequest};
use Illuminate\Support\Facades\Hash;

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

    public function retrieve($id)
    {
        try {
            return response()->json(Permission::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list(Request $request)
    {
        try {

            $permissions = Permission::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                    $q->orWhere('ar_name', 'like', '%' . $request->q . '%');
                }
            })->paginate(5)->withQueryString();

            return response()->json($permissions);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function search(Request $request)
    {

        try {

            $result = [];
            $data = null;

            $data = Permission::where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('name', 'like', "%" . $request->q . "%");
                    $q->orWhere('ar_name', 'like', "%" . $request->q . "%");
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
                })
                ->take(10)
                ->get();

            foreach ($data as $item) {

                $obj = new \stdClass();
                $obj->id = $item->id;
                $obj->name = $item->ar_name;
                $obj->text = $item->ar_name . ' - ' . $item->name;

                $result[] = $obj;
            }

            return response()->json($result);
        } catch (\Exception $e) {

            throw $this->_exception($e->getMessage());
        }
    }
}
