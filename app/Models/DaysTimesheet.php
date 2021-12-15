<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DaysTimesheet extends Model
{
    use HasFactory, Notifiable;
    protected $table = "days_timesheet";
    protected $fillable = [
        'user_id',
        'day',
        'off_day',
        'working_hours',
        'overtime_hours',
        'justified_working_hours',
        'justified_overtime_hours'
    ];
}
