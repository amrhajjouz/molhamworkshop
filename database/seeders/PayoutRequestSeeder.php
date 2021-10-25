<?php

namespace Database\Seeders;

use App\Http\Controllers\Services\PayoutService;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PayoutRequestSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $service = new PayoutService();

      $service->CreatePayoutRequest([
          "amount" => 100,
          "currency" => "USD",
          "purpose_type" => "general_fund", // todo: for later work => make sure this is verified from the validator when we complete the missing parts
          "assignee_id" => 1,
          "details" => "TEST 123",
          "country_id" => 1,
      ]);
    }
}
