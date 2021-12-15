<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\{User};

class DaysTimesheetJustifications extends Model
{
    use HasFactory, Notifiable;
    protected $table = "days_timesheet_justifications";
    protected $fillable = [
        'user_id',
        'days_timesheet_id',
        'reason',
        'working_hours',
        'details',
        'status',
        'rejection_details',
        'reviewed_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
