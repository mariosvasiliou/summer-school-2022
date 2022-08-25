<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditUserFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::edit
     */
    public function given_user_is_not_authenticated_cannot_view_user_edit_form(): void
    {
        $user = User::factory()->createQuietly();
        $this->get(route('users.edit', ['user' => $user->id]))->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::edit
     */
    public function given_user_is_not_authenticated_admin_cannot_view_edit_user_form(): void
    {
        $user = User::factory()->createQuietly();

        $this->actingAs(User::factory()->createQuietly());

        $this->get(route('users.edit', ['user' => $user->id]))
             ->assertStatus(403);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::edit
     */
    public function given_user_is_authenticated_admin_can_view_edit_user_form(): void
    {
        $user = User::factory()->createQuietly();

        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->get(route('users.edit', ['user' => $user->id]))
             ->assertStatus(200)
             ->assertViewIs('pages.users.edit')
             ->assertViewHas('user', $user);
    }


    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::edit
     */
    public function given_user_is_authenticated_admin_can_view_user_edit_form(): void
    {
        $user = User::factory()->admin()->createQuietly();

        $this->actingAs($user);

        $response = $this->get(route('users.edit', ['user' => $user->id]))->getContent();

        $this->assertStringContainsString('Edit User', $response);
        $this->assertStringContainsString('user_update_form', $response);
        $this->assertStringContainsString('Update', $response);
    }
}
