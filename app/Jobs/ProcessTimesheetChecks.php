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
                    $types = ['in', 'out'];
                    $time = Carbon::now();
                    foreach ($checks as $key => $check){
                              if($check->type == $types[$key % 2]){
                                        if($check->type == 'in'){
                                                  $change_factor = strtotime($check->created_at);
                                        }elseif($check->type == 'out'){
                                                  $change_factor = strtotime($check->created_at) - $change_factor;
                                                  $working_hours += $change_factor;
                                        }
                              }else{
                                        if($dayTimesheet = DaysTimesheet::create([
                                                  'user_id' => $user_id,
                                                  'day' => $time->toDateString(),
                                                  'off_day' => $is_off_day,
                                        ])){
                                                  DaysTimesheetJustifications::create([
                                                            'days_timesheet_id' => $dayTimesheet
                                                  ]);
                                        }
                                        break;
                              }
                    }
                    if($working_hours > $default_working_hours){
                              $overtime_hours += ($working_hours - $default_working_hours);
                              $overtime_hours /= 3600;
                    }
                    $working_hours /= 3600;
                    if($dayTimesheet = DaysTimesheet::create([
                              'user_id' => $user_id,
                              'day' => $time->toDateString(),
                              'off_day' => $is_off_day,
                              'working_hours' => $working_hours,
                              'overtime_hours' => $overtime_hours,
                    ])){
                              $monthTimesheetExisting = MonthsTimesheet::whereYear(date('Y'))->whereMonth(date('m'))->exists();
                              if($monthTimesheetExisting){
                                        $monthTimesheet = MonthsTimesheet::whereYear(date('Y'))->whereMonth(date('m'))->firstOrFail();
                                        MonthsTimesheet::where('id', $monthTimesheet['id'])->increment('working_hours', $working_hours);
                                        MonthsTimesheet::where('id', $monthTimesheet['id'])->increment('overtime_hours', $overtime_hours);
                              }else{
                                        MonthsTimesheet::create([
                                                  'user_id' => $user_id,
                                                  'month' => $time->toDateString(),
                                                  'working_hours' => $working_hours,
                                                  'overtime_hours' => $overtime_hours,
                                        ]);
                              }
                              TimesheetUsersChecks::whereYear(date('Y'))->whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->where('user_id', $user['id'])->update([
                                        'handled' => true,
                              ]);
                    }
          }
}
