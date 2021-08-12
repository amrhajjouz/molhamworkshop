<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonorResetPasswordRequest extends Model
{
    protected $table = 'donor_reset_password_requests';
    protected $casts = ['expires_at' => 'datetime:Y-m-d H:i:s', 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s' , 'consumed'=>'boolean'];
    protected $guarded = [];

    public function donor()
    {
        return $this->BelongsTo(Donor::class, 'donor_id', 'id');
    }
}
