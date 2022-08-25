<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditDepartmentFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::edit
     */
    public function given_user_is_not_authenticated_cannot_view_department_edit_form(): void
    {
        $department = Department::factory()->createQuietly();
        $this->get(route('departments.edit', ['department' => $department->id]))->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::edit
     */
    public function given_user_is_not_authenticated_admin_cannot_view_edit_department_form(): void
    {
        $department = Department::factory()->createQuietly();

        $this->actingAs(User::factory()->createQuietly());

        $this->get(route('departments.edit', ['department' => $department->id]))
             ->assertStatus(403);
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::edit
     */
    public function given_user_is_authenticated_admin_can_view_edit_department_form(): void
    {
        $department = Department::factory()->createQuietly();

        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->get(route('departments.edit', ['department' => $department->id]))
             ->assertStatus(200)
             ->assertViewIs('pages.departments.edit')
             ->assertViewHas('department', $department);
    }


    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::edit
     */
    public function given_user_is_authenticated_admin_can_view_department_edit_form(): void
    {
        $department = Department::factory()->createQuietly();

        $this->actingAs(User::factory()->admin()->createQuietly());

        $response = $this->get(route('departments.edit', ['department' => $department->id]))->getContent();

        $this->assertStringContainsString('Edit Department', $response);
        $this->assertStringContainsString('department_update_form', $response);
        $this->assertStringContainsString('Update', $response);
    }
}
