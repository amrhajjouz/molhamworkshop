<?php

namespace Database\Factories;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => $this->faker->phoneNumber,
            'whatsapp_number' => $this->faker->phoneNumber,
            'swish_number' => $this->faker->swiftBicNumber,
            'subscribed_to_newsletter' => false,
            'verified' => false,
            'blocked' => false,
            'closed' => false,
        ];
    }


    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'verified' => true,
            ];
        });
    }

    public function blocked()
    {
        return $this->state(function (array $attributes) {
            return [
                'blocked' => true,
            ];
        });
    }

    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'closed' => true,
            ];
        });
    }
}
