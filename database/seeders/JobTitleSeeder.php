<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\JobTitle::create([
            'name' => ['ar'=>"مدير تنفيذي" , 'en'=>"Chief Executive Officer"],
        ]);
        \App\Models\JobTitle::create([
            'name' => ['ar'=>"منسق محفظة عمليات" , 'en'=>"Operations Coordinator"],
        ]);
    }
}
