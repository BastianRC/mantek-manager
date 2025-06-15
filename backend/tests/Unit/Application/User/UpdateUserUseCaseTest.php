<?php

namespace Tests\Unit\Application\User;

use Mockery;
use Src\User\Application\DTOs\UpdateUserRequestDTO;
use Src\User\Application\UseCases\UpdateUserUseCase;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\ApplicationTestCase;

class UpdateUserUseCaseTest extends ApplicationTestCase
{
    public function test_update_user_use_case_returns_when_data_is_valid()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password, new UserCreatedAt(), new UserUpdatedAt());

        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn($user);
        $repo->shouldReceive('update')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof UserEntity
                    && $arg->getName() === 'Test Doe';
            }))
            ->andReturnUsing(function (UserEntity $user) {
                return $user;
            });

        $useCase = new UpdateUserUseCase($repo);
        $dto = new UpdateUserRequestDTO(1, 'Test Doe', null, null);

        $response = $useCase->execute($dto);

        $this->assertTrue($response->success);
        $this->assertEquals('User updated successfully.', $response->message);
        $this->assertEquals(1, $response->id);
        $this->assertEquals('Test Doe', $response->name);
        $this->assertInstanceOf(UserEmail::class, $response->email);
        $this->assertInstanceOf(UserCreatedAt::class, $response->created_at);
        $this->assertInstanceOf(UserUpdatedAt::class, $response->updated_at);
    }

    public function test_update_user_use_case_throws_exception_when_user_does_not_exist()
    {
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn(null);

        $useCase = new UpdateUserUseCase($repo);
        $dto = new UpdateUserRequestDTO(1, 'Test Doe', null, null);

        $this->expectException(UserNotFoundException::class);

        $useCase->execute($dto);
    }

    public function test_update_user_use_case_updates_only_name_when_other_fields_are_null()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password, new UserCreatedAt(), new UserUpdatedAt());

        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findById')->with(1)->andReturn($user);

        $repo->shouldReceive('update')
            ->once()
            ->with(Mockery::on(function ($arg) use ($email, $password) {
                return $arg instanceof UserEntity
                    && $arg->getName() === 'Test Doe'
                    && $arg->getEmail()->value() === $email->value()
                    && $arg->getPassword()->value() === $password->value();
            }))
            ->andReturnUsing(fn($u) => $u);

        $useCase = new UpdateUserUseCase($repo);
        $dto = new UpdateUserRequestDTO(id: 1, name: 'Test Doe', email: null, password: null);

        $response = $useCase->execute($dto);

        $this->assertEquals('Test Doe', $response->name);
        $this->assertEquals('john@example.com', $response->email->value());
    }
}
