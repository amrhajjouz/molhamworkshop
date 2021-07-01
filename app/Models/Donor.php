<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLog;

class Donor extends Model
{
    use HasActivityLog;
    
    protected  $fillable = ["name","phone","password","email","swish_number","whatsapp_number"];
    protected $hidden = [
        'password',
    ];
}

