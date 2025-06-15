<?php

namespace Tests\Unit\Application\User;

use Mockery;
use Src\User\Application\DTOs\CreateUserRequestDTO;
use Src\User\Application\UseCases\CreateUserUseCase;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\Exceptions\CreateUserException;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\ApplicationTestCase;

class CreateUserUseCaseTest extends ApplicationTestCase
{
    public function test_create_user_use_case_returns_when_data_is_valid()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password, new UserCreatedAt(), new UserUpdatedAt());

        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findByEmail')->with('john@example.com')->andReturn(null);
        $repo->shouldReceive('create')->andReturn($user);

        $useCase = new CreateUserUseCase($repo);
        $dto = new CreateUserRequestDTO('John Doe', 'john@example.com', password_hash('secret123', PASSWORD_BCRYPT));

        $response = $useCase->execute($dto);

        $this->assertTrue($response->success);
        $this->assertEquals('User created successfully.', $response->message);
        $this->assertEquals(1, $response->id);
        $this->assertEquals('John Doe', $response->name);
        $this->assertInstanceOf(UserEmail::class, $response->email);
        $this->assertInstanceOf(UserCreatedAt::class, $response->created_at);
        $this->assertInstanceOf(UserUpdatedAt::class, $response->updated_at);
    }

    public function test_create_user_use_case_throws_exception_when_required_fields_are_missing()
    {
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findByEmail')->andReturn(null);

        $useCase = new CreateUserUseCase($repo);
        $dto = new CreateUserRequestDTO('', 'john@example.com', password_hash('secret123', PASSWORD_BCRYPT));

        $this->expectException(CreateUserException::class);

        $useCase->execute($dto);
    }
}
