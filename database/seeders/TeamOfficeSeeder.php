<?php

namespace Database\Seeders;

use App\Models\TeamOffice;
use Illuminate\Database\Seeder;

class TeamOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب اسطنبول', 'address' => 'تركيا اسطنبول', 'type' => 'head_office', 'place_id' => 9]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب عنتاب', 'address' => 'تركيا عنتاب', 'type' => 'head_office', 'place_id' => 10]);
    }
}
