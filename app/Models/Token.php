<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Token extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    public function tokenable()
    {
         return $this->morphTo();
    }

    public function save(array $options = []){

        if(!$this->exists){
            do {
                $this->api_token = Str::random(30);
            } while (self::where('api_token' , $this->token)->exists());
        }

        $ret = parent::save();
    }


}
