<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TimesheetUsersChecks extends Model
{
          use HasFactory, Notifiable;
          protected $table = "users_checks";
          protected $fillable = [
                    'type',
                    'user_id',
                    'status',
                    'office_id',
                    'off_day',
                    'approved_by',
                    'rejected_by',
                    'rejection_details',
                    'lat',
                    'lng'
          ];
}
