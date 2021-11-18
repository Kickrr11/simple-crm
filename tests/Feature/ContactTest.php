<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\ArrayShape;
use Tests\TestCase;
use Tests\Helpers\PassportUser;

/**
 * Class ContactTest
 * @package Tests\Feature
 */

class ContactTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test - gets all contacts.
     *
     * @return void
     */
    public function test_get_all(): void
    {
        $user = new PassportUser();
        $user();
        $response = $this->get(env("APP_URL") . '/api/contacts');
        $response->assertStatus(200);
    }

    /**
     * Test - contact can be created.
     *
     * @return void
     */

    public function test_contact_can_be_created(): void
    {
        $user = new PassportUser();
        $user();
        $contactData = Contact::factory()->raw();
        $response = $this->json("POST", env("APP_URL") . '/api/contacts', $contactData);
        $response->assertStatus(200);
    }

    /**
     * Test - contact creating validation.
     *
     * @return void
     */

    public function test_contact_creating_validation(): void
    {
        $user = new PassportUser();
        $user();
        $contactData = Contact::factory()->raw();
        unset($contactData['first_name']);
        $response = $this->json("POST", env("APP_URL") . '/api/contacts', $contactData);
        $response->assertStatus(422);
    }

    /**
     * Test - single contact can be viewed.
     *
     * @return void
     */
    public function test_contact_can_be_viewed(): void
    {
        $user = new PassportUser();
        $user();
        $contact = Contact::factory()->create();
        $response = $this->json("GET", env("APP_URL") . "/api/contacts/$contact->id");

        $response->assertStatus(200);
    }

    /**
     * Test - contact can be updated.
     *
     * @return void
     */
    public function test_contact_can_be_updated(): void
    {
        $user = new PassportUser();
        $user();
        $contactData = Contact::factory()->create();
        $response = $this->json("PUT", env("APP_URL") . "/api/contacts/$contactData->id", $contactData->toArray());
        $response->assertStatus(200);
    }

    /**
     * Test - contact can be deleted.
     *
     * @return void
     */
    public function test_contact_can_be_deleted(): void
    {
        $user = new PassportUser();
        $user();
        $contact = Contact::factory()->create();
        $response = $this->json("DELETE", env("APP_URL") . "/api/contacts/$contact->id");
        $response->assertStatus(200);
    }
}
