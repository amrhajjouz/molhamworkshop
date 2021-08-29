<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'section_id' ,
        'direct_manager_id' ,
        'title_id' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'super_admin' => 'boolean',
    ];

    public function section(){
        return $this->hasOne(Section::class , 'id' , 'section_id');
    }

    public function direct_manager(){
        return $this->hasOne(self::class , 'id' , 'direct_manager_id');
    }

    public function title(){
        return $this->hasOne(Title::class , 'id' , 'title_id');
    }

    public function transform(){
        $user = $this->toArray();
        $locale = app()->getLocale();
        return array_merge($user , [
            'section' => [ 'name' => $this->section->name[$locale]] ,
            'title' => [ 'name' => $this->title->name[$locale]] ,
            'direct_manager' => [ 'email' => $this->direct_manager->email] ,
        ]);
    }
}
