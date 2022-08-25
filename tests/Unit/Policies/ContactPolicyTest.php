<?php

namespace Tests\Unit\Policies;


use App\Models\Contact;
use App\Models\User;
use App\Policies\ContactPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Policies\ContactPolicy
 */
class ContactPolicyTest extends TestCase
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
        $policy = new ContactPolicy();
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
    public function given_user_is_authenticated_can_view_any(): void
    {
        $user = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'viewAny'));
        $this->assertTrue($policy->viewAny($user));
        $this->assertTrue($user->can('viewAny', Contact::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::view
     */
    public function given_user_is_authenticated_can_view_contact(): void
    {
        $user    = User::factory()->createOneQuietly();
        $contact = Contact::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'view'));
        $this->assertTrue($policy->view($user, $contact));
        $this->assertTrue($user->can('view', $contact));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::create
     */
    public function given_user_is_authenticated_can_create_contact(): void
    {
        $user = User::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'create'));
        $this->assertTrue($policy->create($user));
        $this->assertTrue($user->can('create', Contact::class));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::update
     */
    public function given_user_is_authenticated_can_update_contact(): void
    {
        $user    = User::factory()->createOneQuietly();
        $contact = Contact::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'update'));
        $this->assertTrue($policy->update($user, $contact));
        $this->assertTrue($user->can('update', $contact));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::delete
     */
    public function given_user_is_authenticated_cannot_delete_contact(): void
    {
        $user    = User::factory()->createOneQuietly();
        $contact = Contact::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'delete'));
        $this->assertFalse($policy->delete($user, $contact));
        $this->assertFalse($user->can('delete', $contact));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::delete
     */
    public function given_user_is_authenticated_admin_can_delete_contact(): void
    {
        $user    = User::factory()->admin()->createOneQuietly();
        $contact = Contact::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'delete'));
        $this->assertTrue($policy->delete($user, $contact));
        $this->assertTrue($user->can('delete', $contact));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::forceDelete
     */
    public function given_user_is_authenticated_cannot_force_delete_contact(): void
    {
        $user    = User::factory()->createOneQuietly();
        $contact = Contact::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'forceDelete'));
        $this->assertFalse($policy->forceDelete($user, $contact));
        $this->assertFalse($user->can('forceDelete', $contact));
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::before
     * @covers ::forceDelete
     */
    public function given_user_is_authenticated_admin_can_force_delete_contact(): void
    {
        $user    = User::factory()->admin()->createOneQuietly();
        $contact = Contact::factory()->createOneQuietly();
        $this->be($user);
        $policy = new ContactPolicy();
        $this->assertNull($policy->before($user, 'forceDelete'));
        $this->assertTrue($policy->forceDelete($user, $contact));
        $this->assertTrue($user->can('forceDelete', $contact));
    }
}
