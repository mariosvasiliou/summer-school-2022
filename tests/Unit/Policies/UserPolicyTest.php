<?php

namespace Tests\Unit\Policies;


use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Policies\UserPolicy
 */
class UserPolicyTest extends TestCase
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
    public function given_user_is_not_authenticated_cannot_do_anything(): void
    {
        $user   = User::factory()->createOneQuietly();
        $policy = new UserPolicy();
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
    public function given_user_is_authenticated_cannot_view_any(): void
    {
        $user = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'viewAny'));
        $this->assertFalse($policy->viewAny($user));
        $this->assertFalse($user->can('viewAny', User::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::viewAny
     */
    public function given_user_is_authenticated_admin_can_view_any(): void
    {
        $user = User::factory()->admin()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
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
    public function given_user_is_authenticated_cannot_view_user(): void
    {
        $user      = User::factory()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'view'));
        $this->assertFalse($policy->view($user, $userModel));
        $this->assertFalse($user->can('view', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::view
     */
    public function given_user_is_authenticated_admin_can_view_user(): void
    {
        $user      = User::factory()->admin()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'view'));
        $this->assertTrue($policy->view($user, $userModel));
        $this->assertTrue($user->can('view', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::create
     */
    public function given_user_is_authenticated_cannot_create_user(): void
    {
        $user = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
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
    public function given_user_is_authenticated_admin_can_create_user(): void
    {
        $user = User::factory()->admin()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
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
    public function given_user_is_authenticated_cannot_update_user(): void
    {
        $user      = User::factory()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'update'));
        $this->assertFalse($policy->update($user, $userModel));
        $this->assertFalse($user->can('update', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::update
     */
    public function given_user_is_authenticated_admin_can_update_user(): void
    {
        $user      = User::factory()->admin()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'update'));
        $this->assertTrue($policy->update($user, $userModel));
        $this->assertTrue($user->can('update', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::delete
     */
    public function given_user_is_authenticated_cannot_delete_user(): void
    {
        $user      = User::factory()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'delete'));
        $this->assertFalse($policy->delete($user, $userModel));
        $this->assertFalse($user->can('delete', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::delete
     */
    public function given_user_is_authenticated_admin_can_delete_user(): void
    {
        $user      = User::factory()->admin()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'delete'));
        $this->assertTrue($policy->delete($user, $userModel));
        $this->assertTrue($user->can('delete', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::forceDelete
     */
    public function given_user_is_authenticated_cannot_force_delete_user(): void
    {
        $user      = User::factory()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'forceDelete'));
        $this->assertFalse($policy->forceDelete($user, $userModel));
        $this->assertFalse($user->can('forceDelete', $userModel));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::forceDelete
     */
    public function given_user_is_authenticated_admin_can_force_delete_user(): void
    {
        $user      = User::factory()->admin()->createOneQuietly();
        $userModel = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new UserPolicy();
        $this->assertNull($policy->before($user, 'forceDelete'));
        $this->assertTrue($policy->forceDelete($user, $userModel));
        $this->assertTrue($user->can('forceDelete', $userModel));
    }
}
