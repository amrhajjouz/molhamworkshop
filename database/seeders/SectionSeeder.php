<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
            ['name' => '{"ar":"قسم الحالات","en":"Cases section"}'],
            ['name' => '{"ar":"قسم الحملات","en":"Campaigns section"}'],
            ['name' => '{"ar":"قسم الكفالات","en":"Sponsorships section"}'],
            ['name' => '{"ar":"قسم المناسبات","en":"Events  section"}'],
            ['name' => '{"ar":"قسم حملات جمع التبرعات","en":"Fundraisers  section"}'],
            ['name' => '{"ar":"قسم المشاريع","en":"Project section"}'],
            ['name' => '{"ar":"قسم المشاريع الصغيرة","en":"Small Businesses Section"}'],
            ]
        );
    }
}
