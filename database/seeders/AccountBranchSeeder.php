<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountBranch;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AccountBranchSeeder extends Seeder
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
        /* START READING FROM CSV*/
        $csvPath = Storage::disk('public')->path("accounts_list.csv");
        $rows = array_map('str_getcsv', file($csvPath));
        $header = array_shift($rows);
        /* END READING FROM CSV*/

        /*Export the received data into perfect array then into database*/
        $array = array();
        foreach ($rows as $row) {
            $combinedArray = array_combine($header, $row); // part of the csv work

            if ($combinedArray["parent_id"] == "null") {
                $combinedArray["parent_id"] = null;
            }
            $combinedArray["name"] = json_encode(["ar" => $combinedArray["name_ar"], "en" => $combinedArray["name_en"]], JSON_UNESCAPED_UNICODE);

            unset($combinedArray["name_ar"]);
            unset($combinedArray["name_en"]);
            $array[] = $combinedArray;
        }

        AccountBranch::insert($array);

        for ($i = 1; $i <= 3; $i++) {
            $accountBranch = AccountBranch::whereType("title")->inRandomOrder()->first();
            DB::table('account_branches')->insert([
                'name' => '{"ar": "Main '.$this->faker->word.'","ar": "Main '.$this->faker->word.'"}',
                'parent_id' => $accountBranch->id,
                'type' => "main",
                'code' => $accountBranch->nextExpectedCode,
                'balance' => 0,
            ]);
    }
}

}
