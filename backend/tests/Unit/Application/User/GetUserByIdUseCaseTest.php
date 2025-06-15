<?php

namespace Tests\Unit\Application\User;

use Mockery;
use Src\User\Application\UseCases\GetUserByIdUseCase;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\ApplicationTestCase;

class GetUserByIdUseCaseTest extends ApplicationTestCase
{
    public function test_get_user_by_id_use_case_returns_user_when_id_exists()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password, new UserCreatedAt(), new UserUpdatedAt());
        
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn($user);

        $useCase = new GetUserByIdUseCase($repo);

        $response = $useCase->execute($user->getId());

        $this->assertTrue($response->success);
        $this->assertEquals('User retrieved successfully.', $response->message);
        $this->assertEquals(1, $response->id);
        $this->assertEquals('john@example.com', $response->email->value());
        $this->assertEquals('John Doe', $response->name);
    }

    public function test_get_user_by_id_use_case_throws_exception_when_user_does_not_exist()
    {
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn(null);

        $useCase = new GetUserByIdUseCase($repo);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('User not found.');

        $useCase->execute(1);
    }
}