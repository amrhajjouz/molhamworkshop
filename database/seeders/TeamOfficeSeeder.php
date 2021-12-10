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
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب غازي عنتاب', 'address' => 'تركيا عنتاب', 'type' => 'head_office', 'place_id' => 10]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب تل أبيض', 'address' => 'سوريا الرقة', 'type' => 'head_office', 'place_id' => 19]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب اعزاز', 'address' => 'سوريا حلب', 'type' => 'head_office', 'place_id' => 4]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب ادلب', 'address' => 'سوريا ادلب', 'type' => 'head_office', 'place_id' => 1]);

        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب عفرين', 'address' => 'سوريا حلب', 'type' => 'branch_office', 'place_id' => 4]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب الباب', 'address' => 'سوريا حلب', 'type' => 'branch_office', 'place_id' => 4]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب دارة عزة', 'address' => 'سوريا حلب', 'type' => 'branch_office', 'place_id' => 4]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب ريف اللاذقية', 'address' => 'سوريا اللاذقية', 'type' => 'branch_office', 'place_id' => 3]);
        TeamOffice::create(['office_manager' => 1, 'name' => 'مكتب أطمة', 'address' => 'سوريا ادلب', 'type' => 'branch_office', 'place_id' => 1]);
    }
}
