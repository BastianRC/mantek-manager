<?php

namespace Tests\Unit\Application\User;

use Mockery;
use Src\User\Application\UseCases\GetUsersListUseCase;
use Src\User\Domain\Entity\UserEntity;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Domain\ValueObject\HashedUserPassword;
use Src\User\Domain\ValueObject\UserCreatedAt;
use Src\User\Domain\ValueObject\UserEmail;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\ApplicationTestCase;

class GetUsersListUseCaseTest extends ApplicationTestCase
{
    public function test_get_users_list_use_case_returns_when_called()
    {
        $firstEmail = new UserEmail('john@example.com');
        $firstPassword = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $firstUser = new UserEntity(1, 'John Doe', $firstEmail, $firstPassword, new UserCreatedAt(), new UserUpdatedAt());

        $secondEmail = new UserEmail('jane@example.com');
        $secondPassword = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $secondUser = new UserEntity(2, 'Jane Doe', $secondEmail, $secondPassword, new UserCreatedAt(), new UserUpdatedAt());

        $users = [$firstUser, $secondUser];

        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findAll')->andReturn($users); // phpcs:ignore

        $useCase = new GetUsersListUseCase($repo);
        $response = $useCase->execute();

        $this->assertTrue($response->success);
        $this->assertEquals('Users retrieved successfully.', $response->message);
        $this->assertEquals('john@example.com', $response->toArray()['data'][0]['email']);
        $this->assertEquals('Jane Doe', $response->toArray()['data'][1]['name']);
        $this->assertCount(2, $response->toArray()['data']);
    }

    public function test_get_users_list_use_case_returns_empty_array_when_no_users_exist()
    {
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findAll')->andReturn([]);

        $useCase = new GetUsersListUseCase($repo);
        $response = $useCase->execute();

        $this->assertTrue($response->success);
        $this->assertEquals('Users retrieved successfully.', $response->message);
        $this->assertIsArray($response->users);
        $this->assertCount(0, $response->users);
    }
}
