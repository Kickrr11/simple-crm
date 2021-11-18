<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\ArrayShape;
use Tests\Helpers\PassportUser;
use Tests\TestCase;
use Arr;


/**
 * Class NoteTest
 * @package Tests\Feature
 */

class NoteTest extends TestCase
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
        $response = $this->get(env("APP_URL") . '/api/notes');
        $response->assertStatus(200);
    }

    /**
     * Test - note for an account can be created.
     *
     * @return void
     * @throws \Throwable
     */

    public function test_note_to_account_can_be_created(): void
    {
        $theNotesData = $this->note_creating_data(new Account());
        $response = $this->json("POST", env("APP_URL") . '/api/notes', $theNotesData);
        $subset = $this->prepare_subset_data("account");
        $response->decodeResponseJson()->assertSubset($subset, false);
        $response->assertStatus(201);
    }

    /**
     * Test - note for an contact can be created.
     *
     * @return void
     * @throws \Throwable
     */

    public function test_note_to_contact_can_be_created(): void
    {
        $theNotesData = $this->note_creating_data(new Contact());
        $response = $this->json("POST", env("APP_URL") . '/api/notes', $theNotesData);
        $subset = $this->prepare_subset_data("contact");
        $response->decodeResponseJson()->assertSubset($subset, false);
        $response->assertStatus(201);
    }

    /**
     * Prepare notes create data
     * @param Model $model
     * @return array
     */

    public function note_creating_data(Model $model): array
    {
        $notesData = Note::factory()->count(1)->for(
            $model::factory(), 'noteable'
        )->raw();
        $user = new PassportUser();
        $user();
        return Arr::get($notesData, 0);
    }

    /**
     * Test - note creating validation.
     *
     * @return void
     */

    public function test_note_created_custom_validation(): void
    {
        $theNotesData = $this->note_creating_data(new User());
        $response = $this->json("POST", env("APP_URL") . '/api/notes', $theNotesData);
        $response->assertStatus(422);
    }

    /**
     * @param string $type
     * @return array
     */

    #[ArrayShape(["data" => "\string[][]"])]
    public function prepare_subset_data(string $type): array
    {
        return [
            "data" => [
                "note" => [
                    "noteable_type" => $type
                ]
            ]
        ];
    }
}
