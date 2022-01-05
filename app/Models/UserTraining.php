<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTraining extends Model
{
    use SoftDeletes;

    protected $table = 'user_trainings';

    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
