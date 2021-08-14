<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DonorResetPasswordRequest extends Model
{
    protected $table = 'donor_reset_password_requests';
    protected $casts = ['expires_at' => 'datetime:Y-m-d H:i:s', 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s', 'consumed' => 'boolean'];
    protected $guarded = [];

    public function donor()
    {
        return $this->BelongsTo(Donor::class, 'donor_id', 'id');
    }

    public function save($options = [])
    {

        if(!$this->exists){
            $this->code = rand(100000 , 999999);
            do {
                $this->code = rand(100000 , 999999);
            } while (DonorResetPasswordRequest::where('code', $this->code)->exists());

            $this->expires_at = Carbon::now()->addMinutes(20)->toDateTimeString();
        }

        return parent::save($options);
    }
}
