<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;
    use HasUserstamps;
    protected  $fillable = ["name","phone","password","email","swish_number","whatsapp_number"];
    protected $hidden = [
        'password',
    ];
}

