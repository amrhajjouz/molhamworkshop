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
        UserSection::create(['section_name' => ['ar'=>'قسم الادارة التنفيذية' , 'en'=>"Executive Management"], 'user_manager_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'محفظة العمليات' , 'en'=>"Operations portfolio"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'محفظة الاستجابة الإنسانية' , 'en'=>"Humanitarian Response Portfolio"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'محفظة الحماية والتعليم' , 'en'=>"Protection and education portfolio"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'محفظة الإعلام والعلاقات العامة' , 'en'=>"Media and public relations portfolio"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'قسم المراقبة والتقييم والمسائلة والتعلم' , 'en'=>"Meal Department"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'قسم التدقيق الداخلي' , 'en'=>"Internal Audit Department"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'قسم تقانة المعلومات' , 'en'=>"Information Technology Department"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'برنامج المأوى' , 'en'=>"Shelter Program"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'البرنامج الطبي' , 'en'=>"Medical Program"], 'user_manager_id' => 1, 'parent_id' => 1]);
        UserSection::create(['section_name' => ['ar'=>'سلسلة الإمداد والتوريد' , 'en'=>"Supply Chain"], 'user_manager_id' => 1, 'parent_id' => 2]);
        UserSection::create(['section_name' => ['ar'=>'المالية' , 'en'=>"Finance"], 'user_manager_id' => 1, 'parent_id' => 2]);
        UserSection::create(['section_name' => ['ar'=>'الموارد البشرية' , 'en'=>"Human Resources"], 'user_manager_id' => 1, 'parent_id' => 2]);
        UserSection::create(['section_name' => ['ar'=>'الإمتثال والشؤون القانونية' , 'en'=>"Compliance and Legal Affairs"], 'user_manager_id' => 1, 'parent_id' => 2]);
        UserSection::create(['section_name' => ['ar'=>'قسم الأمن و إدارة المكاتب التنفيذية' , 'en'=>"Security and Administration Affairs"], 'user_manager_id' => 1, 'parent_id' => 2]);
        UserSection::create(['section_name' => ['ar'=>'برنامج الحالات الإنسانية' , 'en'=>"Humanitarian Cases Program"], 'user_manager_id' => 1, 'parent_id' => 3]);
        UserSection::create(['section_name' => ['ar'=>'برنامج الاستجابة الطارئة' , 'en'=>"Emergency Response Program"], 'user_manager_id' => 1, 'parent_id' => 3]);
        UserSection::create(['section_name' => ['ar'=>'برنامج المشاريع الصغيرة' , 'en'=>"Micro-Finance Program"], 'user_manager_id' => 1, 'parent_id' => 3]);
        UserSection::create(['section_name' => ['ar'=>'برنامج الحماية' , 'en'=>"Protection Program"], 'user_manager_id' => 1, 'parent_id' => 4]);
        UserSection::create(['section_name' => ['ar'=>'برنامج التعليم' , 'en'=>"Education Program"], 'user_manager_id' => 1, 'parent_id' => 4]);
        UserSection::create(['section_name' => ['ar'=>'برنامج المناسبات والهدايا' , 'en'=>"Gifts & Events Program"], 'user_manager_id' => 1, 'parent_id' => 4]);
        UserSection::create(['section_name' => ['ar'=>'العلاقات العامة' , 'en'=>"Public Relations"], 'user_manager_id' => 1, 'parent_id' => 5]);
        UserSection::create(['section_name' => ['ar'=>'الإعلام' , 'en'=>"Media"], 'user_manager_id' => 1, 'parent_id' => 5]);
        UserSection::create(['section_name' => ['ar'=>'شؤون المكاتب الدولية' , 'en'=>"International Offices Affairs"], 'user_manager_id' => 1, 'parent_id' => 5]);

    }
}
