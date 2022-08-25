<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Requests\StoreUserRequest
 */
class StoreUserRequestTest extends TestCase
{
    use LazilyRefreshDatabase;
    use AdditionalAssertions;

    /**
     * @test
     * @date   08/08/2022
     * @author MariosV
     * @covers ::authorize
     */
    public function authorize_returns_false_for_unauthorized_users(): void
    {
        $new = new StoreUserRequest();
        $this->assertFalse($new->authorize());
    }

    /**
     * @test
     * @date   08/08/2022
     * @author MariosV
     * @covers ::authorize
     */
    public function authorize_returns_true_for_authorized_users(): void
    {
        $this->be(User::factory()->createQuietly());
        $new = new StoreUserRequest();
        $this->assertTrue($new->authorize());
    }

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     * @covers ::rules
     */
    public function given_request_rules_are_correct(): void
    {
        $formRequest = new StoreUserRequest();
        $this->assertExactValidationRules([
            'first_name'    => ['required', 'max:255'],
            'last_name'     => ['required', 'max:255'],
            'email'         => ['required', 'email', 'max:50'],
            'gender'        => ['nullable', 'string', 'max:20'],
            'street'        => ['nullable', 'string', 'max:255'],
            'building'      => ['nullable', 'string', 'max:255'],
            'number'        => ['nullable', 'string', 'max:10'],
            'postal_code'   => ['nullable', 'string', 'max:10'],
            'city'          => ['nullable', 'string', 'max:30'],
            'country'       => ['nullable', 'string', 'max:30'],
            'home_number'   => ['nullable', 'string', 'max:30'],
            'mobile_number' => ['nullable', 'string', 'max:30'],
            'work_number'   => ['nullable', 'string', 'max:30'],
            'comments'      => ['nullable', 'string', 'max:65000'],
            'is_admin'      => ['nullable', 'boolean'],
            'password'      => ['required', 'confirmed', Password::defaults()],
            'department_id' => ['nullable', Rule::exists('departments', 'id')->withoutTrashed()],
        ], $formRequest->rules());
    }
}
