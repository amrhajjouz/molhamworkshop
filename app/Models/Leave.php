<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $dates = ['leave_start_date', 'leave_end_date'];

    protected $casts = [
        'leave_start_date' => 'date:Y-m-d',
        'leave_end_date' => 'date:Y-m-d',
    ];

    protected $guarded = [];

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
