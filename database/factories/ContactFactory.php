<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition(): array
    {
        $account = Account::factory()->create();
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'job_title' => $this->faker->jobTitle,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'country_code' => $this->faker->countryCode,
            'city' => $this->faker->city,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'account_id' => $account->id,
        ];
    }
}
