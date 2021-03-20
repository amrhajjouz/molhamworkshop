<?php

namespace App\Facades;

use App\Models\{Cases, Donor, Place, Sponsorship, Student , Sponsor};

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

    /*
     * Mohamd
    * Assign Sponsorship or Student to Sponsors
    *  $object : object from student or sponsorship
    *  Return false Or object from Sponsor
    */
    public static function AssignToSponsor($object , Donor $donor ,$percentage = 0 , $active = true , $request)
    {

        if(!$object->id) return false;
        if(!$donor->id) return false;

        $model_type = null;
        
        if($object instanceof Sponsorship){
            $model_type = '\App\Models\Sponsorship';
        }else if($object instanceof Student){
            $model_type = '\App\Models\Student';
        }else{
            \Log::info('Helper AssignToSponsor assign wront object');
            return false;
        }
        
        $sponsor = Sponsor::where('purpose_type' , $model_type)
                         ->where('purpose_id' , $model_id )
                         ->where('donor_id' , $donor_id)
                         ->first();

        if(!is_null($sponsor)){
            return $sponsor;
        }

        $sponsor = new Sponsor();
        $sponsor->purpose_type = $model_type;
        $sponsor->purpose_id = $object->id;
        $sponsor->percentage = $percentage;
        $sponsor->active = $active;
        $sponsor->save();

        return $sponsor;
    }
}
