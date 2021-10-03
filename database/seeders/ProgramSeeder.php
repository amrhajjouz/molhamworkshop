<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programs')->insert([
            ['name' => '{"ar":"البرنامج الطبي","en":"Medical Program"}'],
            ['name' => '{"ar":"البرنامج لإنساني","en":"Humanitarian Program"}'],
            ['name' => '{"ar":"برنامج المأوى","en":"Shelter Program"}'],
            ['name' => '{"ar":"برنامج الأيتام","en":"Orphan Program"}'],
            ['name' => '{"ar":"برنامج التعليم","en":"Education Program"}'],
            ['name' => '{"ar":"برنامج الحملات","en":"Campaigns Program"}'],
            ['name' => '{"ar":"برنامج المناسيات","en":"Events Program"}']
            ]
        );
    }
}
