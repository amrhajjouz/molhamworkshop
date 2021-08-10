<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ApiError extends Model
{
    protected $table = 'api_errors';
    protected $casts = ['message' => "json"];
    protected $guarded =[];
    public $timestamps = false; 
}
