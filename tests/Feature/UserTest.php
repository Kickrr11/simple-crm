<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\ArrayShape;
use Tests\Helpers\PassportUser;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test - user can receive token.
     *
     * @return void
     * @throws \Throwable
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

    #[ArrayShape(["data" => "string[]"])]
    public function loginResponseSubset(): array
    {
        return [
            "data" => [
                'token_type' => 'Bearer'
            ]
        ];
    }
}
