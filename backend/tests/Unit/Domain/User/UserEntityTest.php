<?php

namespace Tests\Unit\Domain\User;

use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\UnitTestCase;


class UserEntityTest extends UnitTestCase
{
    public function test_user_entity_is_created_correctly()
    {

        $email = new UserEmail('john@example.com');
        $hash = password_hash('secret123', PASSWORD_BCRYPT);
        $password = new HashedUserPassword($hash);
        $user = new UserEntity(1, 'John Doe', $email, $password, new UserCreatedAt(), new UserUpdatedAt());

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail()->value());
        $this->assertEquals($hash, $user->getPassword()->value());
    }
}
