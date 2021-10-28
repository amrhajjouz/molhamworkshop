<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TimesheetDevices extends Model
{
          use HasFactory, Notifiable;
          protected $table = "timesheet_devices";
          protected $fillable = [
                    'brand',
                    'unique_id',
                    'operating_system',
          ];
}
