<?php

use App\Models\{StripeIdealAccount, StripeSepaAccount, StripeSofortAccount, SwishAccount};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

function createRandomPaymentMethods($donorId)
{
    $faker = Faker\Factory::create();
    $methodables = [];
    $methodables["ideal_account"] = StripeIdealAccount::create(["stripe_payment_method_id" => Str::random(20), "owner_name" => $faker->name, "bank_name" => $faker->name]);
    $methodables["sepa_account"] = StripeSepaAccount::create(["stripe_payment_method_id" => Str::random(20), "iban" => $faker->postcode . $faker->postcode,]);
    $methodables["sofort_account"] = StripeSofortAccount::create(["stripe_payment_method_id" => Str::random(20), "owner_name" => Str::substr($faker->name, 0, 10), "country_code" => Str::substr($faker->country, 0, 2),]);
    $methodables["swish_account"] = SwishAccount::create(["number" => rand(100000, 99999999)]);
    foreach ($methodables as $type => $methodable) {
        DB::table('payment_methods')->insert(['methodable_id' => $methodable->id, 'methodable_type' => get_class($methodable), "future_usage" => true, 'donor_id' => $donorId, "type" => $type]);
    }
}
