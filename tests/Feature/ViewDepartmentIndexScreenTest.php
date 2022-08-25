<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewDepartmentIndexScreenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @date   25/7/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::index
     */
    public function given_user_is_not_authenticated_cannot_view_departments_screen(): void
    {
        $this->get(route('departments.index'))->assertRedirect('login');
    }

    /**
     * @test
     * @date   08/08/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::index
     */
    public function given_user_is_authenticated_admin_can_view_departments_screen(): void
    {
        $this->actingAs(User::factory()->admin()->createQuietly());

        $this->get(route('departments.index'))
             ->assertStatus(200)
             ->assertViewIs('pages.departments.index')
             ->assertViewHas('departments');
    }

    /**
     * @test
     * @date   25/7/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::index
     */
    public function given_user_is_authenticated_but_not_admin_cannot_view_departments_screen(): void
    {
        $this->actingAs(User::factory()->createQuietly());

        $this->get(route('departments.index'))
             ->assertStatus(403);
    }

    /**
     * @test
     * @date   25/7/2022
     * @author MariosV
     * @covers \App\Http\Controllers\DepartmentController::index
     */
    public function given_user_is_authenticated_admin_can_view_departments_screen_table(): void
    {
        $this->actingAs(User::factory()->admin()->createQuietly());

        $response = $this->get(route('departments.index'))->getContent();

        $this->assertStringContainsString('Name', $response);
        $this->assertStringContainsString('table-bordered', $response);
        $this->assertStringContainsString('goToCreateView', $response);
    }
}
