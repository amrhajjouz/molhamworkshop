<?php
namespace App\Traits;

trait Tokenable
{
    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function deleteAllTokens(){
        $this->tokens()->delete();
    }
}
