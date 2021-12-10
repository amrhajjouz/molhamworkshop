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
        UserSection::create(['section_name' => ['ar'=>'موارد بشرية' , 'en'=>"Human resources"], 'user_manager_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'المالية' , 'en'=>"Finance"], 'user_manager_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'برامج' , 'en'=>"Programs"], 'user_manager_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'حالات' , 'en'=>"cases"], 'user_manager_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'الفريق التقني' , 'en'=>"The technical team"], 'user_manager_id' => 1]);
    }
}
