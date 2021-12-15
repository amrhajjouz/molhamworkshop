<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiError extends Model
{
    protected $table = 'api_errors';
    protected $casts = ['message' => "json"];
    protected $guarded = [];
    public $timestamps = false;



    public function save($options = [])
    {
        if (!$this->status) $this->status = 400;
        if (!$this->message) $this->message =  ['ar' => 'خطأ غير معروف', 'en' => 'Unkown Error'];
        return parent::save($options);
    }
}
