<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\ContactIsUserException;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Exceptions\ContactIsUserException
 */
class ContactIsUserExceptionTest extends TestCase
{

    /**
     * @test
     * @date   25/8/2022
     * @author MariosV
     */
    public function given_exception_is_thrown_message_is_correct(): void
    {
        $this->expectException(ContactIsUserException::class);
        $this->expectExceptionMessage('Contact is user cannot be deleted');
        throw new ContactIsUserException();
    }
}
