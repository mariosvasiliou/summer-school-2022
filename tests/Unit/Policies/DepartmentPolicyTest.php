<?php

namespace Tests\Unit\Policies;


use App\Models\Department;
use App\Models\User;
use App\Policies\DepartmentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Policies\DepartmentPolicy
 */
class DepartmentPolicyTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @covers ::before
     * @covers ::viewAny
     * @covers ::view
     * @covers ::create
     * @covers ::update
     * @covers ::delete
     * @covers ::forceDelete
     * @return void
     */
    public function given_department_is_not_authenticated_cannot_do_anything(): void
    {
        $user   = User::factory()->createOneQuietly();
        $policy = new DepartmentPolicy();
        $this->assertFalse($policy->before($user, 'viewAny'));
        $this->assertFalse($policy->before($user, 'view'));
        $this->assertFalse($policy->before($user, 'create'));
        $this->assertFalse($policy->before($user, 'update'));
        $this->assertFalse($policy->before($user, 'delete'));
        $this->assertFalse($policy->before($user, 'forceDelete'));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::viewAny
     */
    public function given_department_is_authenticated_cannot_view_any(): void
    {
        $user = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'viewAny'));
        $this->assertFalse($policy->viewAny($user));
        $this->assertFalse($user->can('viewAny', Department::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::viewAny
     */
    public function given_department_is_authenticated_admin_can_view_any(): void
    {
        $user = User::factory()->admin()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'viewAny'));
        $this->assertTrue($policy->viewAny($user));
        $this->assertTrue($user->can('viewAny', User::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::view
     */
    public function given_department_is_authenticated_view_department(): void
    {
        $user  = User::factory()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'view'));
        $this->assertTrue($policy->view($user, $model));
        $this->assertTrue($user->can('view', $model));
    }


    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::create
     */
    public function given_department_is_authenticated_cannot_create_department(): void
    {
        $user = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'create'));
        $this->assertFalse($policy->create($user));
        $this->assertFalse($user->can('create', User::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::create
     */
    public function given_department_is_authenticated_admin_can_create_department(): void
    {
        $user = User::factory()->admin()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'create'));
        $this->assertTrue($policy->create($user));
        $this->assertTrue($user->can('create', User::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::update
     */
    public function given_department_is_authenticated_cannot_update_department(): void
    {
        $user  = User::factory()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'update'));
        $this->assertFalse($policy->update($user, $model));
        $this->assertFalse($user->can('update', $model));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::update
     */
    public function given_department_is_authenticated_admin_can_update_department(): void
    {
        $user  = User::factory()->admin()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'update'));
        $this->assertTrue($policy->update($user, $model));
        $this->assertTrue($user->can('update', $model));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::delete
     */
    public function given_department_is_authenticated_cannot_delete_department(): void
    {
        $user  = User::factory()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'delete'));
        $this->assertFalse($policy->delete($user, $model));
        $this->assertFalse($user->can('delete', $model));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::delete
     */
    public function given_department_is_authenticated_admin_can_delete_department(): void
    {
        $user  = User::factory()->admin()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'delete'));
        $this->assertTrue($policy->delete($user, $model));
        $this->assertTrue($user->can('delete', $model));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::forceDelete
     */
    public function given_department_is_authenticated_cannot_force_delete_department(): void
    {
        $user  = User::factory()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'forceDelete'));
        $this->assertFalse($policy->forceDelete($user, $model));
        $this->assertFalse($user->can('forceDelete', $model));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::forceDelete
     */
    public function given_department_is_authenticated_admin_can_force_delete_department(): void
    {
        $user  = User::factory()->admin()->createOneQuietly();
        $model = Department::factory()->createOneQuietly();
        $this->be($user);
        $policy = new DepartmentPolicy();
        $this->assertNull($policy->before($user, 'forceDelete'));
        $this->assertTrue($policy->forceDelete($user, $model));
        $this->assertTrue($user->can('forceDelete', $model));
    }
}
