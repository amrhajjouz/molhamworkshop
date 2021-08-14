<?php

namespace App\Models;

use App\Traits\Tokenable;
use Illuminate\Database\Eloquent\Model;
use App\Models\{NotificationPreference};

class Donor extends Model
{
    use Tokenable;

    protected  $fillable = ["name", "phone", "password", "email", "swish_number", "whatsapp_number", 'locale', 'currency', 'country_code'];
    protected $hidden = ['password'];

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'code', 'country_code');
    }

    public function notification_preferences()
    {
        return $this->belongsToMany(NotificationPreference::class, 'donor_notification_preferences', 'donor_id', 'preference_id');
    }

    public function delete()
    {
        $this->deleteAllTokens();
        return parent::delete();
    }

    public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function avatar()
    {
        return $this->morphOne('App\Models\Image', 'imageable')->where('type', 'avatar');
    }

    public function reset_password_requests()
    {
        return $this->hasMany('App\Models\DonorResetPasswordRequest', 'donor_id', 'id');
    }
}
