<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserSection extends Model
{
    use SoftDeletes;

    protected $table = 'user_sections';

    protected $appends = ['parent_name'];

    protected $guarded = [];

    protected $casts = ['section_name' => 'json'];

    public function users() {
      return $this->hasMany(User::class,'user_section_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function getParentNameAttribute()
    {
        $name = UserSection::where('id' , $this->parent_id)->get('section_name')->all();
        return $name;
    }

    public function mangerUser(){
        return $this->belongsTo(\App\Models\User::class,'user_manager_id');
    }

}
