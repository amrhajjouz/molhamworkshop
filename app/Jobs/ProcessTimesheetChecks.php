<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\TimesheetUsersChecks;
use App\Models\DaysTimesheet;
use App\Models\DaysTimesheetJustifications;
use App\Models\MonthsTimesheet;

class ProcessTimesheetChecks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $off_days = [
        'east' => ['Fri', 'Sat'],
        'west' => ['Sat', 'Sun']
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            print "start";
            $users = User::select('id', 'office_id')->get();
//                        $users->getCollection()->transform(function ($user, $key){
//                                  $office = $user->office;
//                                  return $user;
//                        });
            foreach ($users as $user){
                print "user";
                $is_off_day = in_array(date('D'), $this->off_days[$user->office->off_days_type]);
                $daysExisting = TimesheetUsersChecks::orderBy('created_at')->whereMonth('created_at', date('m'))->where('user_id', $user['id'])->where('handled', false)->exists();
                if($daysExisting){
                    print "day";
                    $this->checksCalculator($user['id'], $is_off_day);
                }
                print "\n";
            }
        } catch (\Exception $e){
            //
        }
    }

    private function checksCalculator($user_id, $is_off_day){
        print "\n";
        $default_working_hours = 60 * 60 * 8;
        $working_hours = 0;
        $overtime_hours = 0;
        $change_factor = 0;
        $time = Carbon::now();
        $startHour = strtotime(date('Y-m-d') . ' 09:30 AM');
        $inCycle = false;

        $checks = TimesheetUsersChecks::orderBy('created_at')->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->where('user_id', $user_id)->get();
        foreach ($checks as $key => $check){
            if($check['type'] == 'in' && !$inCycle){
                print "Cycle Start at: " . strtotime($check['created_at']) . "\n";
                define('STARTED_AT', strtotime($check['created_at']));
                $change_factor = strtotime($check['created_at']);
                $inCycle = true;
            }elseif ($check['type'] == 'out' && $inCycle){
                print "Cycle End at: " . strtotime($check['created_at']) . "\n";
                $change_factor = strtotime($check['created_at']) - $change_factor;
                $working_hours += $change_factor;
                $inCycle = false;
            }
        }
        print "Working Hours: " . $working_hours;
        if($working_hours > $default_working_hours){
            $overtime_hours += ($working_hours - $default_working_hours);
            $working_hours = $default_working_hours;
        }
        if($dayTimesheet = DaysTimesheet::create([
            'user_id' => $user_id,
            'day' => $time->toDateString(),
            'off_day' => $is_off_day,
            'working_hours' => $working_hours / 3600,
            'overtime_hours' => $overtime_hours / 3600,
        ])){
            print "Day Id: " . $dayTimesheet . "\n";
            $monthTimesheetExisting = MonthsTimesheet::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->exists();
            if($monthTimesheetExisting){
                $monthTimesheet = MonthsTimesheet::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->firstOrFail();
                MonthsTimesheet::where('id', $monthTimesheet['id'])->increment('working_hours', $working_hours / 3600);
                MonthsTimesheet::where('id', $monthTimesheet['id'])->increment('overtime_hours', $overtime_hours / 3600);
            }else{
                MonthsTimesheet::create([
                    'user_id' => $user_id,
                    'month' => $time->toDateString(),
                    'working_hours' => $working_hours / 3600,
                    'overtime_hours' => $overtime_hours / 3600,
                ]);
            }
            if($working_hours < $default_working_hours || STARTED_AT > $startHour){
                print "Justification: ";
                print(($working_hours < $default_working_hours) ? 'working_hours' : 'late_entry');
                print "\n";
                DaysTimesheetJustifications::create([
                    'user_id' => $user_id,
                    'days_timesheet_id' => $dayTimesheet['id'],
                    'reason' => ($working_hours < $default_working_hours) ? 'working_hours' : 'late_entry',
                    'status' => 'pending',
                ]);
            }
            TimesheetUsersChecks::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->where('user_id', $user_id)->update([
                'handled' => true,
            ]);
        }
    }
}
