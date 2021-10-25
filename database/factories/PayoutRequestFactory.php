<?php

namespace Database\Factories;

use App\Http\Controllers\Services\PayoutService;
use App\Models\PayoutRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayoutRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayoutRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $service = new PayoutService();

        return $service->CreatePayoutRequest([
            "amount" => 100,
            "currency" => "USD",
            "purpose_type" => "general_fund", // todo: for later work => make sure this is verified from the validator when we complete the missing parts
            "assignee_id" => 1,
            "details" => "TEST 123",
            "country_id" => 1,
        ]);
    }
}
