<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Token extends Model
{
    use HasFactory;
    
    protected $table = 'tokens';
    
    public function tokenable() {
        return $this->morphTo();
    }
    
    public function save(array $options = []){
        
        if (!$this->exists) {
            do {
                $this->access_token = Str::random(40);
            } while (self::where('access_token' , $this->token)->exists());
        }
        parent::save();
    }
}