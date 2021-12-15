<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Exceptions\ApiErrorException;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Passcode\{VerifyPasscode, Check, UpdateCheck, SubmitJustification};
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Office;
use App\Models\TimesheetDevices;
use App\Models\TimesheetUsersChecks;
use App\Models\DaysTimesheetJustifications;

class PasscodeController extends Controller
{

    public function __construct () {
//                    $this->middleware('auth');
    }

    public function verification(VerifyPasscode $request)
    {
        try {
            $data = $request->validated();
            $user = User::where('timesheet_passcode', $data['passcode'])->firstOrFail();
//                              $user['unique_id'] = $data['unique_id'];
//                              $user['brand'] = $data['brand'];
//                              $user['os'] = $data['os'];
            $timesheetDevice = TimesheetDevices::where('id', $user['timesheet_device_id'])->exists();
            if($timesheetDevice){
                $timesheetDeviceData = TimesheetDevices::where('unique_id', $data['unique_id'])->firstOrFail();
                //TimesheetDevices::destroy($timesheetDeviceData['id']);
                $user['timesheet_device_data'] = $timesheetDeviceData;
                User::where('id', $user['id'])->update([
                    'timesheet_device_id' => $timesheetDeviceData['id']
                ]);
                $user['login'] = true;
            }else{
                $timesheet_device_id = TimesheetDevices::create([
                    'user_id' => $user['id'],
                    'brand' => $data['brand'],
                    'unique_id' => $data['unique_id'],
                    'operating_system' => $data['os'],
                ]);
                User::where('id', $user['id'])->update([
                    'timesheet_device_id' => $timesheet_device_id->id
                ]);
//                                        $user['timesheet_device_new_id'] = $timesheet_device_id->id;
            }
//                              $user['exist'] = $timesheetDevice;
            return response()->json($user);
        } catch (\Exception $e) {
            //throw new ApiErrorException($e->getMessage());
            return response()->json(['login' => false]);
        }
    }

    public function check (Check $request){
        try{
            $res = array();
            $data = $request->validated();
            $user = User::where('timesheet_passcode', $data['passcode'])->firstOrFail();
            $timesheetDevice = TimesheetDevices::where([
                ['id', '=', $user['timesheet_device_id']],
                ['brand', '=', $data['brand']],
                ['unique_id', '=', $data['unique_id']]
            ])->exists();
            if($timesheetDevice){
                $office = Office::where('id', $user['office_id'])->exists();
                if($office){
                    $officeData = Office::where('id', $user['office_id'])->firstOrFail();
                    $nextCheckType = $data['check_type'];
                    $next_check = TimesheetUsersChecks::create([
                        'type' => $nextCheckType,
                        'user_id' => $user->id,
                        'office_id' => $user['office_id'],
                        //'status' => '',
                        'lat' => $data['lat'],
                        'lng' => $data['lng']
                    ]);
                    $res['last_check'] = true;
                    $res['next_check'] = $next_check;
                }else{
                    $res['office'] = false;
                }
            }else{
                $res['exist'] = false;
            }
            return response()->json($res);
        }catch (\Exception $e){
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function timesheet($id){
        try {
            $checks = TimesheetUsersChecks::orderBy('created_at', 'desc')->where('user_id', $id)->paginate(20);
            return response()->json($checks);

        } catch (\Exception $e) {
            //return ['error' => $e->getMessage()];
            return response()->json([]);
        }
    }

    public function updateCheck(UpdateCheck $request){
        try{
            $data = $request->validated();
            $check = TimesheetUsersChecks::where('id', $data['id'])->firstOrFail();
            if(!$check['handled']) {
                if (TimesheetUsersChecks::where('id', $data['id'])->update(['type' => $data['check_type']])) {
                    return response()->json(['updated' => true, 'check_type' => $data['check_type'], 'handled' => $check['handled']]);
                }
            }else{
                return response()->json(['updated' => false, 'error' => 'handled']);
            }
            return response()->json(['updated' => false]);
        } catch (\Exception $e){
            throw new ApiErrorException($e->getMessage());
        }
    }

    public function justifications($id){
        try {
            $checks = DaysTimesheetJustifications::orderBy('created_at', 'desc')->where('user_id', $id)->paginate(20);
            return response()->json($checks);

        } catch (\Exception $e) {
            //return ['error' => $e->getMessage()];
            return response()->json([]);
        }
    }

    public function submitJustification (SubmitJustification $request){
        try{
            $res = array();
            $data = $request->validated();
            $user = User::where('timesheet_passcode', $data['passcode'])->firstOrFail();
            $timesheetDevice = TimesheetDevices::where([
                ['id', '=', $user['timesheet_device_id']],
                ['brand', '=', $data['brand']],
                ['unique_id', '=', $data['unique_id']]
            ])->exists();
            if($timesheetDevice){
                if(DaysTimesheetJustifications::where('id', $data['id'])->update([
                    'details' => $data['details'],
                    'working_hours' => $data['working_hours'],
                    'status' => 'needs_approval'
                ])){
                    $res['success'] = true;
                }else{
                    $res['success'] = false;
                }
            }else{
                $res['success'] = false;
            }
            return response()->json($res);
        }catch (\Exception $e){
            $res['success'] = false;
            return response()->json($res);
        }
    }
}

