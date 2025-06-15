<?php

namespace Tests\Unit\Domain\User;

use InvalidArgumentException;
use Src\User\Domain\ValueObject\UserEmail;
use Tests\UnitTestCase;

class UserEmailTest extends UnitTestCase
{
    public function test_user_email_is_created_when_format_is_valid()
    {
        $email = new UserEmail('valid@example.com');
        $this->assertEquals('valid@example.com', $email->value());
    }

    public function test_user_email_throws_exception_when_format_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email');

        new UserEmail('not-an-email');
    }
}