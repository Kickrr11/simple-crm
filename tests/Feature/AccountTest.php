<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;
use Tests\Helpers\PassportUser;
use Tests\TestCase;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccountTest
 * @package Tests\Feature
 */

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test - gets all accounts.
     *
     * @return void
     * @throws \Throwable
     */
    public function test_get_all(): void
    {
        $user = new PassportUser();
        $user();
        $response = $this->get(env("APP_URL") . '/api/accounts');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test - account can be created.
     *
     * @return void
     */
    public function test_account_can_be_created(): void
    {
        $user = new PassportUser();
        $user();
        $accountData = Account::factory()->raw();
        $response = $this->json("POST", env("APP_URL") . '/api/accounts', $accountData);
        $response->assertStatus(201)->assertJson([
            'success' => true
        ]);
    }

    /**
     * Test - single account can be viewed.
     *
     * @return void
     */
    public function test_account_can_be_viewed(): void
    {
        $user = new PassportUser();
        $user();
        $account = Account::factory()->create();
        $response = $this->json("GET", env("APP_URL") . "/api/accounts/$account->id");

        $response->assertStatus(200);
    }

    /**
     * Test - account can be updated.
     *
     * @return void
     */
    public function test_account_can_be_updated(): void
    {
        $user = new PassportUser();
        $user();
        $account = Account::factory()->create();
        $response = $this->json("PUT", env("APP_URL") . "/api/accounts/$account->id", $account->toArray());
        $response->assertStatus(200);
    }

    /**
     * Test - account can be deleted.
     *
     * @return void
     */
    #[NoReturn] public function test_account_can_be_deleted(): void
    {
        $user = new PassportUser();
        $user();
        $accountId = Account::factory()->create()->id;
        $response = $this->json("DELETE", env("APP_URL") . "/api/accounts/$accountId");
        $response->assertStatus(200);
    }
}
