<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Requests\StoreDepartmentRequest
 */
class StoreDepartmentRequestTest extends TestCase
{
    use AdditionalAssertions;
    use LazilyRefreshDatabase;

    /**
     * @test
     * @date   25/7/2022
     * @author MariosV
     * @covers ::authorize
     */
    public function authorize_returns_false_for_unauthorized_users(): void
    {
        $new = new StoreDepartmentRequest();
        $this->assertFalse($new->authorize());
    }

    /**
     * @test
     * @date   25/7/2022
     * @author MariosV
     * @covers ::authorize
     */
    public function authorize_returns_true_for_authorized_users(): void
    {
        $this->be(User::factory()->createQuietly());
        $new = new StoreDepartmentRequest();
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
        $formRequest = new StoreDepartmentRequest();
        $this->assertExactValidationRules([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
        ], $formRequest->rules());
    }
}
