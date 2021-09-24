<?php

namespace App\Models;

class Donor extends BaseModel
{
    const UPDATED_BY = null;

    protected  $fillable = ["name","phone","password","email","swish_number","whatsapp_number"];
    protected $hidden = [
        'password',
    ];
}
