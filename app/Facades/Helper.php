<?php

namespace App\Facades;
use App\Models\Cases;

class Helper{
    
     /*
     * Mohamd
     * Generate random string
     */
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

    /*
    * Mohamd
    * Generate serial number for case model
    * syntax => year - month - number case in this month
    */
    public static function getCaseSerialNumber()
    {
        
        
        $year = date("Y");
        $month = date("m");
        
        $casesInThisMonth = Cases::whereYear('created_at' , $year)->whereMonth('created_at' , $month)->count();

        $serialNumber = $year.$month.($casesInThisMonth + 1);
        // dd($year , $month , $casesInThisMonth);
        return $serialNumber;
    }
}
