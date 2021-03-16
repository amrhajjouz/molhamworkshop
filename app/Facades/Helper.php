<?php

namespace App\Facades;

use App\Models\{Cases, Place};

class Helper
{

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

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
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

        $casesInThisMonth = Cases::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();

        $serialNumber = $year . $month . ($casesInThisMonth + 1);
        // dd($year , $month , $casesInThisMonth);
        return $serialNumber;
    }

    // return city with parents names
    public static function getFullNamePlace(Place $place)
    {

        $arr = [$place->name];
        $name = null;
        $country_name = null;

        $country = $place->country;

        if ($country) $country_name = $country->name;

        $first_parent = $place->parent;
        if ($first_parent) {
            $arr[] =  $first_parent->name;
            if ($first_parent->type == 'province' && $first_parent->country) $country_name = $first_parent->country->name;
            $second_parent = $first_parent->parent;
            if ($second_parent) {
                $arr[] = $second_parent->name;
                if ($second_parent->type == 'province' && $second_parent->country) $country_name = $second_parent->country->name;

                $third_parent = $second_parent->parent;
                if ($third_parent) {
                    $arr[] = $third_parent->name;
                    if ($third_parent->type == 'province' && $third_parent->country) $country_name = $third_parent->country->name;
                }
            }
        }

        
        foreach(array_reverse($arr) as $val => $item){
            if(is_null($name)){
                $name = $item; 
            }else{
                $name .= ' - ' . $item;
            }
        }

        if($country_name){
            return $country_name . ' - ' . $name;
        }else{
            return $name;
        }
    }
}
