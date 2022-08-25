<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversNothing
 */
class CreateNewDepartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::store
     */
    public function given_user_is_not_authenticated_cannot_create_department(): void
    {
        $department = Department::factory()->create();
        $this->post(route('departments.store'), $department->getAttributes())->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::store
     */
    public function given_user_is_not_authenticated_admin_cannot_create_department(): void
    {
        $department = Department::factory()->make();
        $data       = $department->getAttributes();
        Arr::set($data, 'name', 'Test');

        $this->actingAs(User::factory()->createQuietly());

        $this->post(route('departments.store'), $data)
             ->assertStatus(403);

        $this->assertDatabaseMissing('departments', $data);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::store
     */
    public function given_user_is_authenticated_admin_can_create_department(): void
    {
        $department = Department::factory()->make();
        $data       = $department->getAttributes();
        Arr::set($data, 'name', 'Test');

        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->post(route('departments.store'), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('departments.index'));

        $this->assertDatabaseHas('departments', $data);
    }

}
