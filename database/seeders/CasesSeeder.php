<?php

namespace Database\Seeders;

use App\Models\Cases;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $countries = ['TR' , 'SY' , 'USA' , 'UAE' , 'BE' , 'EH' , 'EG' , 'IQ'];

        for ($i = 1; $i <= 20; $i++) {
            $case = Cases::create([
                'beneficiary_name' => getRandomArabicWords(rand(5,12)),
                'funded' => $faker->boolean(),
                'urgent' => $faker->boolean(),
                'required' => $faker->numberBetween($min = 3, $max = 1000),
                'beneficiaries_count' => $faker->numberBetween($min = 1, $max = 30),
                'is_hidden' => $faker->boolean(),
                'category_id' => $faker->numberBetween($min = 4, $max = 5),
                'place_id' => $faker->numberBetween($min = 1, $max = 10),
                'country_code' => $countries[$faker->numberBetween($min = 0, $max = 7)],
            ]);

            $contents = [];
            foreach (['ar', 'en', 'fr', 'de', 'tr', 'es'] as $l) {
                $contents['title'][$l] = ['proofread' =>$faker->boolean() , 'auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(5,12)) : getRandomWords(rand(5,12))];
                $contents['description'][$l] = ['proofread' =>$faker->boolean() ,'auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(15,20)) : getRandomWords(rand(15,20))];
                $contents['details'][$l] = ['proofread' =>$faker->boolean() ,'auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(30,100)) : getRandomWords(rand(30,100))];
            }

            $case->target->updateContentFields($contents);
        }
    }
}
