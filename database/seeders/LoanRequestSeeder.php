<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoanRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<=20; $i++) {
            DB::table('loan_requests')->insert([
                'user_id' => 1,
                'amount' => mt_rand(5000,10000),
                'receiving_date' => date("Y-m-d H:i:s",mt_rand(1262055681,1262055681)),
                'return_date' => date("Y-m-d H:i:s",mt_rand(1262055681,1262055681)),
                'status' => array_rand(['pending', 'under_review', 'accepted'],2),
                'details' => 'Dummy text ' . $i,
            ]);
        }
    }
}
