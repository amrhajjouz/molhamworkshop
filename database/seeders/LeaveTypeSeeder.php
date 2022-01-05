<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveType::create(['leave_name' => 'إجازة ادارية', 'details'=>'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => ' اجازات غير مدفوعة الأجر', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازات مرضية', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة الامومة', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة الأبوة', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة الزواج', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة الحضانة', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة الوفاة', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة الحج', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => ' اجازة ساعية', 'details'=> 'اضف شرح للاجازة هنا']);
        LeaveType::create(['leave_name' => 'اجازة المهمات', 'details'=> 'اضف شرح للاجازة هنا']);

    }
}
