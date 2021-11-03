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
                        $users = User::select('id', 'office_id')->get();
                        $users->getCollection()->transform(function ($user, $key){
                                  $office = $user->office;
                                  return $user;
                        });
                        foreach ($users as $user){
                                  $is_off_day = in_array(date('D'), $this->off_days[$user->office->off_days_type]);
                                  $daysExisting = TimesheetUsersChecks::orderBy('created_by')->whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->where('user_id', $user['id'])->exists();
                                  if($daysExisting){
                                            $days = TimesheetUsersChecks::orderBy('created_by')->whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->where('user_id', $user['id']);
                                            $this->checksCalculator($user['id'], $days, $is_off_day);
                                  }
                        }
              } catch (\Exception $e){
                        //
              }
    }

          private function checksCalculator($user_id,$checks = array(), $is_off_day = false){
                    $default_working_hours = 60 * 60 * 8;
                    $working_hours = 0;
                    $overtime_hours = 0;
                    $change_factor = 0;
                    $time = Carbon::now();
                    $startHour = strtotime(date('Y-m-d') . ' 09:30 AM');
                    $inCycle = false;
                    foreach ($checks as $key => $check){
                              if($check->type == 'in' && !$inCycle){
                                        define('STARTED_AT', strtotime($check->created_at));
                                        $change_factor = strtotime($check->created_at) - $change_factor;
                                        $inCycle = true;
                              }elseif ($check->type == 'out' && $inCycle){
                                        $change_factor = strtotime($check->created_at) - $change_factor;
                                        $working_hours += $change_factor;
                                        $inCycle = false;
                              }
                    }
                    if($working_hours > $default_working_hours){
                              $overtime_hours += ($working_hours - $default_working_hours);
                    }
                    if($dayTimesheet = DaysTimesheet::create([
                              'user_id' => $user_id,
                              'day' => $time->toDateString(),
                              'off_day' => $is_off_day,
                              'working_hours' => $working_hours / 3600,
                              'overtime_hours' => $overtime_hours / 3600,
                    ])){
                              $monthTimesheetExisting = MonthsTimesheet::whereYear(date('Y'))->whereMonth(date('m'))->exists();
                              if($monthTimesheetExisting){
                                        $monthTimesheet = MonthsTimesheet::whereYear(date('Y'))->whereMonth(date('m'))->firstOrFail();
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
                                        DaysTimesheetJustifications::create([
                                                  'days_timesheet_id' => $dayTimesheet,
                                                  'reason' => ($working_hours < $default_working_hours) ? 'working_hours' : 'late_entry',
                                        ]);
                              }
                              TimesheetUsersChecks::whereYear(date('Y'))->whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->where('user_id', $user['id'])->update([
                                        'handled' => true,
                              ]);
                    }
          }
}
