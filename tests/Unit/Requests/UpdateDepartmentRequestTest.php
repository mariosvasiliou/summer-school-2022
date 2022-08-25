<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Requests\UpdateDepartmentRequest
 */
class UpdateDepartmentRequestTest extends TestCase
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
        $new = new UpdateDepartmentRequest();
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
        $new = new UpdateDepartmentRequest();
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
        $formRequest = new UpdateDepartmentRequest();
        $this->assertExactValidationRules([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
        ], $formRequest->rules());
    }
}
