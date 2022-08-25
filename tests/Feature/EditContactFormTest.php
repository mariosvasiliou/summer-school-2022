<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::edit
     */
    public function given_user_is_not_authenticated_cannot_view_contact_edit_form(): void
    {
        $contact = Contact::factory()->create();
        $this->get(route('contacts.edit', ['contact' => $contact->id]))->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::edit
     */
    public function given_user_is_authenticated_can_view_edit_contact_form(): void
    {
        $contact = Contact::factory()->create();

        $this->actingAs(User::factory()->createQuietly());

        $this->get(route('contacts.edit', ['contact' => $contact->id]))
             ->assertStatus(200)
             ->assertViewIs('pages.contacts.edit')
             ->assertViewHas('contact', $contact);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::edit
     */
    public function given_user_is_authenticated_can_view_contact_edit_form(): void
    {
        $contact = Contact::factory()->create();

        $this->actingAs(User::factory()->createQuietly());

        $response = $this->get(route('contacts.edit', ['contact' => $contact->id]))->getContent();

        $this->assertStringContainsString('Edit Contact', $response);
        $this->assertStringContainsString('contact_update_form', $response);
        $this->assertStringContainsString('Update', $response);
    }
}
