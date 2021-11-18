<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\PassportUser;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test - user can receive token.
     *
     * @return void
     */
    public function test_user_can_receive_token(): void
    {
        \Artisan::call('passport:install',['-vvv' => true]);
        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $response = $this->post(env("APP_URL") . '/api/login', [
            "email" => "test@gmail.com",
            "password" => "123456"
        ]);
        $subset = $this->loginResponseSubset();
        $response->decodeResponseJson()->assertSubset($subset, false);
        $response->assertStatus(200);
    }

    public function loginResponseSubset()
    {
        return [
            "data" => [
                'token_type' => 'Bearer'
            ]
        ];
    }
}
