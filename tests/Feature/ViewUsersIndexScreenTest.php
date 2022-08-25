<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewUsersIndexScreenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::index
     */
    public function given_user_is_not_authenticated_cannot_view_users_screen(): void
    {
        $this->get(route('users.index'))->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::index
     */
    public function given_user_is_authenticated_but_not_admin_cannot_view_users_screen(): void
    {
        $this->actingAs(User::factory()->createQuietly());

        $this->get(route('users.index'))
             ->assertStatus(403);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::index
     */
    public function given_user_is_authenticated_admin_can_view_users_screen(): void
    {
        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->get(route('users.index'))
             ->assertStatus(200)
             ->assertViewIs('pages.users.index')
             ->assertViewHas('users');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::index
     */
    public function given_user_is_authenticated_admin_can_view_users_screen_table(): void
    {
        $this->actingAs(User::factory()->admin()->createQuietly());

        $response = $this->get(route('users.index'))->getContent();

        $this->assertStringContainsString('Contact', $response);
        $this->assertStringContainsString('table-bordered', $response);
        $this->assertStringContainsString('goToCreateView', $response);
    }
}
