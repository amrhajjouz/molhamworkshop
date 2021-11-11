<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $project = Project::create([
                'funded' => $faker->boolean(),
            ]);

            $contents = [];
            foreach (['ar', 'en', 'fr', 'de', 'tr', 'es'] as $l) {
                $contents['title'][$l] = ['proofread' =>$faker->boolean() , 'auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(5,12)) : getRandomWords(rand(5,12))];
                $contents['description'][$l] = ['proofread' =>$faker->boolean() ,'auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(15,20)) : getRandomWords(rand(15,20))];
                $contents['details'][$l] = ['proofread' =>$faker->boolean() ,'auto_generated' => ($l == 'ar' || $l == 'en') ? false : ((rand(0,1)) ? true : false), 'value' => ($l == 'ar') ? getRandomArabicWords(rand(30,100)) : getRandomWords(rand(30,100))];
            }

            $project->target->updateContentFields($contents);
            $project->target->update(['published_at' => date('Y-m-d H:i:s' , rand(strtotime('2021-01-01'), time()))]);
        }
    }
}
