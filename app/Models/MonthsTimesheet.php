<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MonthsTimesheet extends Model
{
    use HasFactory, Notifiable;
    protected $table = "months_timesheet";
    protected $fillable = [
        'user_id',
        'month',
        'working_hours',
        'overtime_hours',
    ];
}
