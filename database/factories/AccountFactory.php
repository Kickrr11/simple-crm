<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'address' => "string", 'postal_code' => "string", 'country_code' => "string", 'city' => "string", 'is_active' => "int", 'user_id' => "\Illuminate\Support\HigherOrderCollectionProxy|mixed"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->text,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'country_code' => $this->faker->countryCode,
            'city' => $this->faker->city,
            'is_active' => 1,
            'user_id' => User::factory()->create()->id
        ];
    }
}
