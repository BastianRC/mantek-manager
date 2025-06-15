<?php

namespace Tests\Unit\Domain\Auth;

use InvalidArgumentException;
use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Tests\UnitTestCase;

class HashedUserPasswordTest extends UnitTestCase
{
    public function test_hashed_password_is_created_when_bcrypt_hash_is_valid()
    {
        $hash = password_hash('secret123', PASSWORD_BCRYPT);
        $vo = new HashedUserPassword($hash);

        $this->assertEquals($hash, $vo->value());
    }

    public function test_hashed_password_throws_exception_when_hash_is_not_bcrypt()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be a valid bcrypt hash.');

        new HashedUserPassword('not-a-bcrypt-hash');
    }
}