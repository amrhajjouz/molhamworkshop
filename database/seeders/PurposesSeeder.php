<?php

namespace Database\Seeders;

use App\Models\Account;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurposesSeeder extends Seeder
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
     */ //todo: change later to reflect the real table
    public function run()
    {
       $types = ["تبرع زكاة","دعم اداري","الحالة","الحملة","الكفالة","المناسبة"];

        for ($i = 0; $i <= 1; $i++) {
            $account = Account::inRandomOrder()->first();

            DB::table('purposes')->insert([
                'name' => $types[$i],
                'title' => $types[$i],
                'account_id' => $account->id,
                'program_id' => $account->id,
                'section_id' => $account->id,
                'targetable_type' => $this->faker->name,
                'targetable_id' => $account->id,
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            $account = Account::inRandomOrder()->first();
            $rand = rand(2,5);
            $name =rand(0,10000)." {$types[$rand]}";
            DB::table('purposes')->insert([
                'name' => $name,
                'title' => $name,
                'account_id' => $account->id,
                'program_id' => $account->id,
                'section_id' => $account->id,
                'targetable_type' => $this->faker->name,
                'targetable_id' => $account->id,
            ]);
        }
    }

}
