<?php
namespace App\Traits;

/**
 * HasToken
 */
trait HasToken
{
    
    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }


    public function getCurrentToken(){
        return request()->bearerToken();
    }

    public function deleteAllTokens(){
        $this->tokens()->delete();
    }
}
