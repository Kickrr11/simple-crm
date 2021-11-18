<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CountriesTableSeeder;

/**
 * Class DatabaseSeeder
 * @package Database\Seeders
 */

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(UserSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
