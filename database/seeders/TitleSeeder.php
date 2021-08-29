<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Title::create(['name'=>['ar' => 'مدير' , 'en' => 'manager']]);
        Title::create(['name'=>['ar' => 'مسؤول موارد بشرية' , 'en' => 'hr']]);
    }
}
