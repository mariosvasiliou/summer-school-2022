<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewContactIndexScreenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::index
     */
    public function given_user_is_not_authenticated_cannot_view_contacts_screen(): void
    {
        $this->get(route('contacts.index'))->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::index
     */
    public function given_user_is_authenticated_can_view_contacts_screen(): void
    {
        $this->actingAs(User::factory()->createQuietly());

        $this->get(route('contacts.index'))
             ->assertStatus(200)
             ->assertViewIs('pages.contacts.index')
             ->assertViewHas('contacts');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\ContactController::index
     */
    public function given_user_is_authenticated_can_view_contacts_screen_table(): void
    {
        $this->actingAs(User::factory()->createQuietly());

        $response = $this->get(route('contacts.index'))->getContent();

        $this->assertStringContainsString('Name', $response);
        $this->assertStringContainsString('table-bordered', $response);
        $this->assertStringContainsString('goToCreateView', $response);
    }
}
