<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateExistingContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::update
     */
    public function given_user_is_not_authenticated_cannot_update_contact(): void
    {
        $contact = Contact::factory()->create();
        $this->patch(route('contacts.update', ['contact' => $contact->id]), $contact->getAttributes())->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::update
     */
    public function given_user_is_authenticated_can_update_existing_physical_contact(): void
    {
        $contact = Contact::factory()->createOneQuietly();
        $data    = $contact->getAttributes();
        Arr::forget($data, 'is_legal_entity');
        Arr::set($data, 'first_name', 'Test');

        $this->actingAs(User::factory()->createQuietly());

        $this->patch(route('contacts.update', ['contact' => $contact->id]), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('contacts.index'));

        $this->assertDatabaseHas('contacts', ['first_name' => 'Test', 'is_legal_entity' => 0]);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::update
     */
    public function given_user_is_authenticated_can_update_existing_legal_contact(): void
    {
        $contact = Contact::factory()->legal()->createOneQuietly();
        $data    = $contact->getAttributes();
        Arr::set($data, 'legal_name', 'Test LTD');

        $this->actingAs(User::factory()->createQuietly());

        $this->patch(route('contacts.update', ['contact' => $contact->id]), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('contacts.index'));

        $this->assertDatabaseHas('contacts', ['legal_name' => 'Test LTD', 'is_legal_entity' => 1]);
    }

}
