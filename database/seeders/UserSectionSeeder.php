<?php

namespace Database\Seeders;

use App\Models\UserSection;
use Illuminate\Database\Seeder;

class UserSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSection::create(['section_name' => 'HR',]);
        UserSection::create(['section_name' => 'Finance',]);
    }
}
