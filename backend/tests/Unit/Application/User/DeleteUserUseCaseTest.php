<?php

namespace Tests\Unit\Application\User;

use Mockery;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Application\UseCases\DeleteUserUseCase;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\ApplicationTestCase;

class DeleteUserUseCaseTest extends ApplicationTestCase
{
    public function test_delete_user_use_case_returns_true_when_is_successful()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password, new UserCreatedAt(), new UserUpdatedAt());

        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn($user);
        $repo->shouldReceive('delete')->with($user);

        $useCase = new DeleteUserUseCase($repo);
        $response = $useCase->execute($user->getId());

        $this->assertTrue($response->success);
        $this->assertEquals('User deleted successfully.', $response->message);
    }

    public function test_delete_user_use_case_throws_exception_when_user_does_not_exist()
    {
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn(null);

        $useCase = new DeleteUserUseCase($repo);

        $this->expectException(UserNotFoundException::class);

        $useCase->execute(1);
    }
}
