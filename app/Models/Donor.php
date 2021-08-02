<?php

namespace App\Models;

use App\Traits\HasToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasToken;
    
    protected  $fillable = ["name","phone","password","email","swish_number","whatsapp_number", 'theme_mode' , 'theme_color' , 'locale' , 'currency' , 'country_code'];
    protected $hidden = [
        'password', 
    ];


    public function country(){
        return $this->hasOne('App\Models\Country' , 'code' , 'country_code');
    }


    public function delete(){
        $this->deleteAllTokens();
        return parent::delete();
    }
}

