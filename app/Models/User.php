<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserSection;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at','contract_starting_date', 'graduation_year', 'document_issuance_date', 'document_expiration_date'];

    protected $guarded = [];

    protected $appends = ['member_translate_words'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'graduation_year' => 'date:Y-m-d',
        'document_issuance_date' => 'date:Y-m-d',
        'document_expiration_date' => 'date:Y-m-d',
        'first_name' => 'json',
        'last_name' => 'json',
        'father_name' => 'json',
        'mother_name' => 'json',
    ];

    //Member translate words
    public function getMemberTranslateWordsAttribute(){

        //$member_translate_words[] = [
        // '0' => 'employment_level',
        //]
        $member_translate_words = [];
        
        if ($this->employment_level == 'ceo'){
            $member_translate_words[] = 'مدير تنفيذي';
        }
        if ($this->employment_level == 'manager'){
            $member_translate_words[] = 'مدير';
        }
        if ($this->employment_level == 'coordinator'){
            $member_translate_words[] = 'المنسق';
        }
        if ($this->employment_level == 'senior_officer'){
            $member_translate_words[] = 'مدير القسم';
        }
        if ($this->employment_level == 'officer'){
            $member_translate_words[] = 'المسؤول التنفيذي';
        }
        if ($this->employment_level == 'assistant'){
            $member_translate_words[] = 'مساعد';
        }
        if ($this->employment_level == 'volunteer'){
            $member_translate_words[] = 'متطوع';
        }
        return $member_translate_words;
    }

    public function userSection() {
        return $this->belongsTo(UserSection::class,'user_section_id');
    }

    public function manger(){
        return $this->hasOne(\App\Models\UserSection::class,'user_manager_id');
    }

}
