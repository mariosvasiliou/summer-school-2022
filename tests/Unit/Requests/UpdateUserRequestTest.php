<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Requests\UpdateUserRequest
 */
class UpdateUserRequestTest extends TestCase
{
    use LazilyRefreshDatabase;
    use AdditionalAssertions;

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers ::authorize
     */
    public function authorize_returns_false_for_unauthorized_users(): void
    {
        $new = new UpdateUserRequest();
        $this->assertFalse($new->authorize());
    }

    /**
     * @test
     * @date   08/8/2022
     * @author MariosV
     * @covers ::authorize
     */
    public function authorize_returns_true_for_authorized_users(): void
    {
        $this->be(User::factory()->createQuietly());
        $new = new UpdateUserRequest();
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
        $formRequest = new UpdateUserRequest();
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
            'department_id' => ['nullable', Rule::exists('departments', 'id')->withoutTrashed()],
        ], $formRequest->rules());
    }
}
