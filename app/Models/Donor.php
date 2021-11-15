<?php

namespace App\Models;

use App\Traits\Tokenable;
use Illuminate\Database\Eloquent\Model;
use App\Models\{NotificationPreference};

class Donor extends Model
{
    use Tokenable;

    protected  $guarded = [];
    protected $hidden = ['password', "email_verification_token"];

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'code', 'country_code');
    }

    public function notificationPreferences()
    {
        return $this->belongsToMany(NotificationPreference::class, 'donor_notification_preferences', 'donor_id', 'preference_id');
    }

    public function delete()
    {
        $this->deleteAllTokens();
        return parent::delete();
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function avatar()
    {
        return $this->morphOne('App\Models\Image', 'imageable')->where('type', 'avatar');
    }

    public function resetPasswordRequests()
    {
        return $this->hasMany('App\Models\DonorResetPasswordRequest', 'donor_id', 'id');
    }

    public function donationItems()
    {
        return $this->morphMany('App\Models\DonationItem', 'purpose');
    }

    public function savedItems()
    {
        return $this->hasMany('App\Models\SavedItem', 'donor_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription', 'donor_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'donor_id');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback', 'donor_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'liker');
    }
   
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commenter');
    }
}
