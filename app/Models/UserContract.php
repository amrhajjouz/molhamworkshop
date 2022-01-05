<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContract extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'contract_start_date', 'contract_end_date'];

    protected $casts = [
        'contract_start_date' => 'date:Y-m-d',
        'contract_end_date' => 'date:Y-m-d',
    ];

    protected $appends = ['contract_period', 'translate_word'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(TeamOffice::class, 'office_id');
    }

    public function userSection()
    {
        return $this->belongsTo(UserSection::class, 'user_section_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function getContractPeriodAttribute()
    {
        $contract_period_in_months = contractPeriod($this->contract_start_date, $this->contract_end_date);
        return $contract_period_in_months;
    }

    public function getTranslateWordAttribute()
    {

        $translate_words = [];
        if ($this->contract_type == 'full_time') {
            $translate_words[] = 'دوام كامل';
        } else if ($this->contract_type == 'part_time') {
            $translate_words[] = 'نصف دوام';
        } else if ($this->contract_type == 'indefinite') {
            $translate_words[] = 'غير محددة الأجل';
        } else if ($this->contract_type == 'freelance') {
            $translate_words[] = 'عقد العمل الحر';
        } else if ($this->contract_type == 'consultant_contracts') {
            $translate_words[] = 'عقد المستشارين';
        } else if ($this->contract_type == 'field_work') {
            $translate_words[] = 'عقد العمل الميداني';
        } else if ($this->contract_type == 'project_employee_contracts') {
            $translate_words[] = 'نصف دوام';
        }
        return $translate_words;
    }
}
