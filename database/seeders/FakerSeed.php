<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Country, Cases, Section, Category, Place, Donor , Campaign , Sponsorship , Student , Event , Fundraiser};


class FakerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        if(0) return;
        $count = 50;

        
        for ($i = 0; $i < $count; $i++) {
            /////////////////////// User /////////////////////////
            
            User::create([
                'name' => 'Mohamd Ghanoum' . $i,
                'email' => 'mohamd' . $i . '@admin.com',
                'password' => Hash::make('123123'),
            ]);



            /////////////////////// Country /////////////////////////

            Country::create(["name" => "country".$i]);


            Place::create([
                'name' => 'place'.$i,
                'type' => 'city',
                'parent_id' => 1,
            ]);


            /////////////////////// Donor /////////////////////////
            Donor::create([
                'name' => 'donor'.$i+4,
                'email' => 'donor'.$i + 4 .'@donor.com',
                'password' => Hash::make(12345678),
            ]);

            /////////////////////// Cases /////////////////////////
            $case = new Cases();

            $case->beneficiary_name = 'Faker_beneficiary_name'.$i;
            $case->serial_number =$i + 500 ; //generate unique number 
            $case->country_id = 1;
            $case->status = "unfunded";


            $options = ['target' => [
                "required" => 500 + $i ,
                "visible" => true,
                    "documented" => false ,
                    "archived" => false ,
                    "beneficiaries_count" => 2 ,
                    "category_id" => 4 ,
                    ]
            , "places_ids" => [2]]; 

            $case->save($options);

            /////////////////////// Campaign /////////////////////////
            $campaign = new Campaign();

            $campaign->name = 'Faker_name'.$i;
            $campaign->funded = false;

            $options = ['target' => [
                "required" => 500 + $i ,
                "visible" => true,
                    "documented" => false ,
                    "archived" => false ,
                    "beneficiaries_count" => 2 ,
                    "category_id" => 4 ,
                    ]
            , "places_ids" => [2]]; 

            $campaign->save($options);
       
            /////////////////////// Sponsorship /////////////////////////
      
            $sponsor_ship = new Sponsorship();

            $sponsor_ship->beneficiary_name = 'Faker_beneficiary_name' . $i;
            $sponsor_ship->beneficiary_birthdate = date( 'Y-m-d' ,time() - (24 * 100 * 3600));
            $sponsor_ship->country_id = 1;
            $sponsor_ship->sponsored = false;

            $options = ['target' => [
                "required" => 500 + $i ,
                "visible" => true,
                    "documented" => false ,
                    "archived" => false ,
                    "beneficiaries_count" => 2 ,
                    "category_id" => 4 ,
                    ]
            , "places_ids" => [2]]; 

            $sponsor_ship->save($options);

            /////////////////////// Student /////////////////////////
      
            $student = new Student();

            $student->name = 'Faker_name' . $i;
            $student->country_id = 1;
            $student->semesters_count =$i;
            $student->current_semester =$i - 1;
            $student->status ='not_funded';

            $options = ['target' => [
                "required" => 500 + $i ,
                "visible" => true,
                    "documented" => false ,
                    "archived" => false ,
                    "beneficiaries_count" => 2 ,
                    "category_id" => 4 ,
                    ]
            , "places_ids" => [2]]; 

            $student->save($options);
       

            /////////////////////// Event /////////////////////////
      
            $event = new Event();

            $event->donor_id = $i;
            $event->date = date( 'Y-m-d' ,time() + (24 * 100 * 3600));
            $event->verified =0;
            $event->public_visibility =1;
            $event->implemented =0;
            $event->youtube_video_url ="www.youtube".$i.".com";

            $options = ['target' => [
                "required" => 500 + $i ,
                "visible" => true,
                    "documented" => false ,
                    "archived" => false ,
                    "beneficiaries_count" => 2 ,
                    "category_id" => 4 ,
                    ]
            , "places_ids" => []];

            $event->save($options);
       
            /////////////////////// Fundraiser /////////////////////////
      
            $fundraiser = new Fundraiser();

            $fundraiser->donor_id = $i;
            $fundraiser->verified =0;
            $fundraiser->public_visibility =1;

            $options = ['target' => [
                "required" => 500 + $i ,
                "visible" => true,
                    "documented" => false ,
                    "archived" => false ,
                    "beneficiaries_count" => 2 ,
                    "category_id" => 4 ,
                    ]
            , "places_ids" => []];

            $fundraiser->save($options);
       
            
        } //end for

    }
}
