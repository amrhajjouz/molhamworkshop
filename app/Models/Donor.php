<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasActivityLog , HasEventLog};

class Donor extends Model
{
    use HasActivityLog , HasEventLog;
    
    protected  $fillable = ["name","phone","password","email","swish_number","whatsapp_number"];
    protected $hidden = [
        'password',
    ];
}

