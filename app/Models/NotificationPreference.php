<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
   protected $table = "notification_preferences";
   public $timestamps = false;
   protected $guarded = [];
}

