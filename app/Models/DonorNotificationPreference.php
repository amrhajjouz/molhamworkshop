<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonorNotificationPreference extends Model
{
   protected $table = "donor_notification_preferences";
   public $timestamps = false;
   protected $guarded = [];
}

