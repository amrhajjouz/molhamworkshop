<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DaysTimesheetJustifications;
use App\Models\DaysTimesheet;
use App\Models\MonthsTimesheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class JustificationsController extends Controller {

    public function __construct () {
        $this->middleware('auth');
    }

    public function approve (Request $request){
        try {
            $user_id = Auth::id();
            $justifiedDay = DaysTimesheetJustifications::findOrFail($request->id);
            $day = DaysTimesheet::findOrFail($justifiedDay['days_timesheet_id']);
            $dayDate = new Carbon($day['day']);
            $monthTimesheet = MonthsTimesheet::whereYear('created_at', $dayDate->year)->whereMonth('created_at', $dayDate->month)->firstOrFail();
            if(DaysTimesheetJustifications::where('id', $request->id)->update([
                'status' => 'approved',
                'reviewed_by' => $user_id,
            ])){
                $default_working_hours = 8 * 3600;
                $working_hours = $justifiedDay['working_hours'];
                $working_hours *= 3600;
                $overtime = 0;
                if($working_hours > $default_working_hours){
                    $overtime += $working_hours - $default_working_hours;
                    $working_hours = $default_working_hours;
                }
                DaysTimesheet::where('id', $day['id'])->update([
                    'justified_working_hours' => $working_hours / 3600,
                    'justified_overtime_hours' => $overtime / 3600
                ]);
                MonthsTimesheet::where('id', $monthTimesheet['id'])->decrement('working_hours', $day['working_hours']);
                MonthsTimesheet::where('id', $monthTimesheet['id'])->decrement('overtime_hours', $day['overtime_hours']);
                MonthsTimesheet::where('id', $monthTimesheet['id'])->increment('working_hours', $working_hours / 3600);
                MonthsTimesheet::where('id', $monthTimesheet['id'])->increment('overtime_hours', $overtime / 3600);
                return response(['done' => true]);
            }
        } catch (\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public function reject (Request $request){
        try {
            $user_id = Auth::id();
            if(DaysTimesheetJustifications::where('id', $request->id)->update([
                'status' => 'rejected',
                'rejection_details' => $request->message,
                'reviewed_by' => $user_id,
            ])){
                return response(['done' => true]);
            }
        } catch (\Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public function retrive($id){
        try {

            $justification = DaysTimesheetJustifications::with(['user'])->findOrFail($id);

            return response()->json($justification);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function list (Request $request) {

        try {

            $justifications = DaysTimesheetJustifications::with(['user'])->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

            return response()->json($justifications);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}
