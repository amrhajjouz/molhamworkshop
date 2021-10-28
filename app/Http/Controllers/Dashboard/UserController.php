<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimesheetDevices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\{CreateUserRequest, UpdateUserRequest};

use App\Models\User;

class UserController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function create (CreateUserRequest $request) {

        try {

            // Create User
            $user = User::create($request->validated());

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
            $data = User::findOrFail($id);
            $device = TimesheetDevices::where('id', $data['timesheet_device_id'])->exists();
            if($device) {
                $deviceData = TimesheetDevices::where('id', $data['timesheet_device_id'])->firstOrFail();
                $data['device_data'] = $deviceData;
            }
            return response()->json($data);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteUserDevice($id){
        try {

            $data = User::findOrFail($id);
            if(TimesheetDevices::destroy($data['timesheet_device_id'])){
                User::where('id', $id)->update([
                    'timesheet_device_id' => 0,
                ]);
                return response()->json(['deleted' => true]);
            }
            return response()->json(['deleted' => false]);

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

}
