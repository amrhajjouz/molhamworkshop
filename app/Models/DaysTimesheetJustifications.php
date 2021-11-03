<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DaysTimesheetJustifications extends Model
{
          use HasFactory, Notifiable;
          protected $table = "days_timesheet_justifications";
          protected $fillable = [
                    'days_timesheet_id',
                    'working_hours',
                    'details',
                    'status',
                    'rejection_details',
                    'reviewed_by',
          ];
}
