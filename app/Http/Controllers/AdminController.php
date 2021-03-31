<?php

namespace App\Http\Controllers;

use App\Common\Base\{BaseController};
use App\Http\Requests\Admin\{CreateRequest, UpdateRequest};
use App\Models\{User, Sponsor, Donor, Admin};

class AdminController extends BaseController
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->model = \App\Models\Sponsor::class;
    }

    public function create(CreateRequest $request)
    {
        try {
            $data = $request->validated();

            $model = $data['adminable_type']::find($data['adminable_id']);

            $user = User::findOrfail($data['user_id']);

            $model_type = null;
            $response = [];


            foreach ($data['role']  as $role) {
                $admin = Admin::where('adminable_type', $data['adminable_type'])
                    ->where('adminable_id', $model->id)
                    ->where('user_id', $user->id)
                    ->where('role', $role)
                    ->first();


                if (is_null($admin)) {
                    $new = Admin::create([
                        'adminable_id' => $data['adminable_id'],
                        'adminable_type' => $data['adminable_type'],
                        'user_id' => $user->id,
                        'role' => $role,
                    ]);

                    $new->user; // attach user to new

                    $response[] = $new;
                }
            }


            return $this->_response($response);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());;
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $data = $request->validated();

            $model_type = $data['adminable_type'];
            $model_id = $data['adminable_id'];
            $roles = $data['role'];

            $model = $model_type::findOrFail($model_id);

            $user = User::findOrfail($data['user_id']);

            $to_delete = Admin::where('adminable_type', $data['adminable_type'])
                ->where('adminable_id', $model->id)
                ->where('user_id', $user->id)
                ->get();
            //delete old records
            foreach ($to_delete  as $item) {
                $item->delete();
            }

            $response = [];

            foreach ($roles  as $role) {
                $new = Admin::create([
                    'user_id' => $data['user_id'],
                    'adminable_id' => $model_id,
                    'adminable_type' => $model_type,
                    'role' => $role,
                ]);

                $response[] = $new;
            }


            return $this->_response($response);
        } catch (\Exception $e) {
            throw $this->_exception($e->getMessage());
        }
    }

    /* 
     * Soft delete 
    */  
    public function delete(Request $request){
        

        
    }
    
}
