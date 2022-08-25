<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CreateNewContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::store
     */
    public function given_user_is_not_authenticated_cannot_create_contact(): void
    {
        $contact = Contact::factory()->create();
        $this->post(route('contacts.store'), $contact->getAttributes())->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::store
     */
    public function given_user_is_authenticated_can_create_physical_contact(): void
    {
        $contact = Contact::factory()->make();
        $data    = $contact->getAttributes();
        Arr::forget($data, 'is_legal_entity');
        Arr::set($data, 'first_name', 'Test');

        $this->actingAs(User::factory()->createQuietly());

        $this->post(route('contacts.store'), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('contacts.index'));

        $this->assertDatabaseHas('contacts', $data);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::store
     */
    public function given_user_is_authenticated_can_create_legal_contact(): void
    {
        $contact = Contact::factory()->legal()->make();
        $data    = $contact->getAttributes();
        Arr::set($data, 'legal_name', 'Test LTD');

        $this->actingAs(User::factory()->createQuietly());

        $this->post(route('contacts.store'), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('contacts.index'));

        $this->assertDatabaseHas('contacts', $data);
    }

}
