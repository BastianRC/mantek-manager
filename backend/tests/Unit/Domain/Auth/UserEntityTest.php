<?php

namespace Tests\Unit\Domain\Auth;

use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Tests\UnitTestCase;
use Src\Auth\Domain\Entity\UserEntity;
use Src\Auth\Domain\ValueObject\UserEmail;

class UserEntityTest extends UnitTestCase
{
    public function test_user_entity_is_created_correctly()
    {

        $email = new UserEmail('john@example.com');
        $hash = password_hash('secret123', PASSWORD_BCRYPT);
        $password = new HashedUserPassword($hash);
        $user = new UserEntity(1, 'John Doe', $email, $password);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail()->value());
        $this->assertEquals($hash, $user->getPassword()->value());
    }

    public function test_matches_password_returns_true_when_plain_password_is_correct()
    {
        $email = new UserEmail('john@example.com');
        $hash = password_hash('secret123', PASSWORD_BCRYPT);
        $password = new HashedUserPassword($hash);
        $user = new UserEntity(1, 'John', $email, $password);

        $this->assertTrue($user->matchesPassword('secret123'));
    }

    public function test_matches_password_returns_false_when_plain_password_is_wrong()
    {
        $email = new UserEmail('john@example.com');
        $hash = password_hash('secret123', PASSWORD_BCRYPT);
        $password = new HashedUserPassword($hash);
        $user = new UserEntity(1, 'John', $email, $password);

        $this->assertFalse($user->matchesPassword('wrongpassword'));
    }
}
