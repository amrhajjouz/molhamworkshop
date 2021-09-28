<?php

namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DonorSeeder extends Seeder
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
        $password = Hash::make('12345678');

        for ($i = 1; $i <= 500; $i++) {
            DB::table('donors')->insert([
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => $password,
                'phone' => $this->faker->phoneNumber,
                'swish_number' => $this->faker->swiftBicNumber,
                'subscribed_to_newsletter' => $this->faker->boolean,
                'verified' => false,
                'blocked' => false,
                'closed' => false,
            ]);
        }
    }

}
