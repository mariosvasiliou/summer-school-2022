<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateExistingDepartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::update
     */
    public function given_user_is_not_authenticated_cannot_update_department(): void
    {
        $department = Department::factory()->create();
        $this->patch(route('departments.update', ['department' => $department->id]), $department->getAttributes())->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::update
     */
    public function given_user_is_not_authenticated_admin_cannot_update_existing_department(): void
    {
        $department = Department::factory()->createOneQuietly();
        $data       = $department->getAttributes();
        Arr::set($data, 'name', 'Test');

        $this->actingAs(User::factory()->createQuietly());

        $this->patch(route('departments.update', ['department' => $department->id]), $data)
             ->assertStatus(403);

        $this->assertDatabaseMissing('departments', ['name' => 'Test']);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::update
     */
    public function given_user_is_authenticated_admin_can_update_existing_department(): void
    {
        $department = Department::factory()->createOneQuietly();
        $data       = $department->getAttributes();
        Arr::set($data, 'name', 'Test');

        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->patch(route('departments.update', ['department' => $department->id]), $data)
             ->assertSessionHasNoErrors()
             ->assertRedirect(route('departments.index'));

        $this->assertDatabaseHas('departments', ['name' => 'Test']);
    }
}
