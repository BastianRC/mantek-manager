<?php

namespace Tests\Unit\Application\Auth;

use Src\Auth\Application\UseCases\ValidateUserUseCase;
use Src\Auth\Domain\Entity\UserEntity;
use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Src\Auth\Domain\ValueObject\UserEmail;
use Tests\ApplicationTestCase;

class ValidateUserUseCaseTest extends ApplicationTestCase
{
    public function test_validate_use_case_when_user_is_valid()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password);

        $useCase = new ValidateUserUseCase();
        $response = $useCase->execute($user);

        $this->assertTrue($response->success);
        $this->assertEquals('User has been successfully validated.', $response->message);
        $this->assertEquals(1, $response->id);
        $this->assertEquals('john@example.com', $response->email);
        $this->assertEquals('John Doe', $response->name);
    }
}
