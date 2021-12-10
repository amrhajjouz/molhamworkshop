<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'first_name' => ['ar'=>$this->faker->firstName , 'en'=>$this->faker->firstName],
            'last_name' => ['ar'=>$this->faker->lastName , 'en'=>$this->faker->lastName],
            'father_name' => ['ar'=>$this->faker->name , 'en'=>$this->faker->name],
            'mother_name' => ['ar'=>$this->faker->name , 'en'=>$this->faker->name],
            'user_section_id' => $this->faker->randomElement([1,2,3,4,5]),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('12345678'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
