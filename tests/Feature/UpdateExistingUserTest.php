<?php

namespace Tests\Feature;

use App\Models\User;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateExistingUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::update
     */
    public function given_user_is_not_authenticated_cannot_update_user(): void
    {
        $user = User::factory()->create();
        $this->patch(route('users.update', ['user' => $user->id]), $user->getAttributes())->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::update
     */
    public function given_user_is_not_authenticated_admin_cannot_update_existing_user(): void
    {
        $user = User::factory()->createOneQuietly();
        $data = $user->getAttributes();
        Arr::set($data, 'email', 'test@test.example');
        Arr::set($data, 'first_name', fake()->firstName());
        Arr::set($data, 'last_name', fake()->lastName());


        $this->actingAs(User::factory()->createQuietly());

        $this->patch(route('users.update', ['user' => $user->id]), $data)
             ->assertStatus(403);

        $this->assertDatabaseMissing('users', ['email' => 'test@test.example']);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\UserController::update
     */
    public function given_user_is_authenticated_admin_can_update_existing_user(): void
    {
        $user = User::factory()->createOneQuietly();
        $data = $user->getAttributes();
        Arr::set($data, 'email', 'test@test.example');
        Arr::set($data, 'first_name', fake()->firstName());
        Arr::set($data, 'last_name', fake()->lastName());

        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->patch(route('users.update', ['user' => $user->id]), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', ['email' => 'test@test.example']);
    }
}
