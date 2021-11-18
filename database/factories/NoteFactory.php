<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class NoteFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(["body" => "string"])]
    public function definition(): array
    {
        return [
            "body" => $this->faker->realText
        ];
    }
}
