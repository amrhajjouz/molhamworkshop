<?php

use App\Models\{Donor, StripeIdealAccount, StripeSepaAccount, StripeSofortAccount, SwishAccount};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

function createRandomPaymentMethods($donorId)
{
    $faker = Faker\Factory::create();
    $methodables = [];
    $methodables["stripe_ideal_account"] = ["type" => "ideal", "methodable" => StripeIdealAccount::create(["stripe_payment_method_id" => Str::random(20), "owner_name" => $faker->name, "bank_name" => $faker->name])];
    $methodables["stripe_sepa_account"] = ["type" => "sepa", "methodable" => StripeSepaAccount::create(["stripe_payment_method_id" => Str::random(20), "iban" => $faker->postcode . $faker->postcode,])];
    $methodables["stripe_sofort_account"] = ["type" => "sofort", "methodable" => StripeSofortAccount::create(["stripe_payment_method_id" => Str::random(20), "owner_name" => Str::substr($faker->name, 0, 10), "country_code" => Str::substr($faker->country, 0, 2),])];
    $methodables["swish_account"] = ["type" => "swish", "methodable" => SwishAccount::create(["number" => rand(100000, 99999999)])];
    foreach ($methodables as $methodableType => $data) {
        DB::table('payment_methods')->insert(['methodable_id' => $data['methodable']->id, 'methodable_type' => $methodableType, "future_usage" => true, 'donor_id' => $donorId, "type" => $data['type']]);
    }
}


function createRandomDonorSavedItem(Donor $donor)
{
    $donor->saved_items()->create(['saveable_type' => 'user', 'saveable_id' => 1]);
    $donor->saved_items()->create(['saveable_type' => 'user', 'saveable_id' => 2]);
    $donor->saved_items()->create(['saveable_type' => 'donor', 'saveable_id' => 1]);
    $donor->saved_items()->create(['saveable_type' => 'donor', 'saveable_id' => 2]);
}
