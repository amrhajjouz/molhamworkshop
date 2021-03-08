<?php

namespace App\Facades;


class Helper{
    
    //mohamd ... get random string
    public static function  generateRandomString($length = 10)
    {
        $token = "";
        
        $codeAlphabet  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        
        $max = strlen($codeAlphabet);
        
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
        
        return $token;
    }
}
