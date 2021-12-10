<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWorkExperience extends Model
{
    use SoftDeletes;

    protected $table = 'user_work_experiences';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
