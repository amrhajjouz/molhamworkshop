<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Receiver;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Receiver::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => 'active',
            'country_id' => Country::Factory(),
        ];
    }

    public function suspended()
    {
        return $this->status(function (array $attributes) {
            return [
                'status' => 'suspended',
            ];
        });
    }
    public function closed()
    {
        return $this->status(function (array $attributes) {
            return [
                'status' => 'closed',
            ];
        });
    }
}
