<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AccountSeeder extends Seeder
{
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
    }
}
