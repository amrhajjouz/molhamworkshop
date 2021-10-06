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


function createRandomDonorSavedItems(Donor $donor)
{
    $saveable_types = ['case', 'campaign', 'sponsorship', 'event', 'post'];
    for ($i=1; $i<=15; $i++) {
        $donor->savedItems()->create(['saveable_type' => $saveable_types[rand(0,3)], 'saveable_id' => rand(1, 100)]);
    }
}

function createRandomSubscriptions($donorId)
{
    /*$faker = Faker\Factory::create();
    $methodables = [];
    $methodables["stripe_ideal_account"] = ["type" => "ideal", "methodable" => StripeIdealAccount::create(["stripe_payment_method_id" => Str::random(20), "owner_name" => $faker->name, "bank_name" => $faker->name])];
    $methodables["stripe_sepa_account"] = ["type" => "sepa", "methodable" => StripeSepaAccount::create(["stripe_payment_method_id" => Str::random(20), "iban" => $faker->postcode . $faker->postcode,])];
    $methodables["stripe_sofort_account"] = ["type" => "sofort", "methodable" => StripeSofortAccount::create(["stripe_payment_method_id" => Str::random(20), "owner_name" => Str::substr($faker->name, 0, 10), "country_code" => Str::substr($faker->country, 0, 2),])];
    $methodables["swish_account"] = ["type" => "swish", "methodable" => SwishAccount::create(["number" => rand(100000, 99999999)])];
    
    foreach ($methodables as $methodableType => $data) {
        DB::table('payment_methods')->insert(['methodable_id' => $data['methodable']->id, 'methodable_type' => $methodableType, "future_usage" => true, 'donor_id' => $donorId, "type" => $data['type']]);
    }*/
}


function listDummyCases($length = 20){
    $faker = Faker\Factory::create();

    $cases = [];
    for ($i = 1; $i <= $length; $i++) {
        $cases[] = [
            'id' => $i,
            'title' => (object)['ar' => (object)['value'=> $faker->word , 'auto_generated'=>$faker->boolean]],
            'description' => (object)['ar' => (object)['value'=> $faker->text , 'auto_generated'=>$faker->boolean]],
            'details' => (object)['ar' => (object)['value'=> '<p>'.$faker->text . "</p>" , 'auto_generated'=>$faker->boolean]],
            'required' => (object)['usd' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000) , 'eur' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000) , 'try' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000)],
            'received' => (object)['usd' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000) , 'eur' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000) , 'try' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000)],
            'donation' => [],
            'liked_by_auth' => $faker->boolean,
            'funded_by_auth' => $faker->boolean,
            'saved_by_auth' => $faker->boolean,
            'likes_count' => $faker->numberBetween($min = 3, $max = 1000),
            'urgent' => $faker->boolean,
            'published_at' => date('Y-m-d H:i:s' , $faker->unixTime($max = 'now')),
            'preview_images' => null,
            'funded' => $faker->boolean,
        ];
    }
    return $cases ;
}