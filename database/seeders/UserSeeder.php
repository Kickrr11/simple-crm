<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Kaloyan",
            'email' => "k.katzarov11@gmail.com",
            'password' => Hash::make('secret'),
        ]);
    }
}
