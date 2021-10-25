<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('r_receivers')->insert([
            [
                'name' => 'عمر حجوز',
                'status' => 'active',
                'country_id' => '1'
            ],
            [
                'name' => 'بدر الدين شيخ سالم',
                'status' => 'active',
                'country_id' => '1'
            ],
        ]);
    }
}
