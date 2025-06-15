<?php

namespace Tests\Unit\Application\Auth;

use Mockery;

use Src\Auth\Application\DTOs\LoginRequestDto;
use Src\Auth\Application\UseCases\LoginUserUseCase;
use Src\Auth\Domain\Entity\UserEntity;
use Src\Auth\Domain\Exceptions\InvalidCredentialsException;
use Src\Auth\Domain\Exceptions\UserNotFoundException;
use Src\Auth\Domain\Repositories\UserRepositoryInterface;
use Src\Auth\Domain\ValueObject\HashedUserPassword;
use Src\Auth\Domain\ValueObject\UserEmail;
use Tests\ApplicationTestCase;

class LoginUserUseCaseTest extends ApplicationTestCase
{
    public function test_login_use_case_successful_when_credentials_are_valid()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password);


        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findByEmail')->with('john@example.com')->andReturn($user);
        $repo->shouldReceive('createToken')->with($user)->andReturn('dummy-token');

        $useCase = new LoginUserUseCase($repo);

        $dto = new LoginRequestDto('john@example.com', 'secret123');
        $response = $useCase->execute($dto);

        $this->assertTrue($response->success);
        $this->assertEquals('Successful login.', $response->message);
        $this->assertEquals('dummy-token', $response->token);
        $this->assertEquals(1, $response->id);
        $this->assertEquals('john@example.com', $response->email);
        $this->assertEquals('John Doe', $response->name);
    }

    public function test_login_use_case_fails_when_password_is_wrong()
    {
        $email = new UserEmail('john@example.com');
        $password = new HashedUserPassword(password_hash('secret123', PASSWORD_BCRYPT));
        $user = new UserEntity(1, 'John Doe', $email, $password);

        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findByEmail')->with('john@example.com')->andReturn($user);
        $repo->shouldReceive('createToken')->with($user)->andReturn('dummy-token');

        $useCase = new LoginUserUseCase($repo);
        $dto = new LoginRequestDto('john@example.com', 'wrong-password');

        $this->expectException(InvalidCredentialsException::class);
        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('Invalid credentials');
        
        $useCase->execute($dto);
    }

    public function test_login_use_case_fails_when_user_is_not_found()
    {
        /** @var \Mockery\MockInterface&UserRepositoryInterface $repo */
        $repo = Mockery::mock(UserRepositoryInterface::class); // phpcs:ignore

        $repo->shouldReceive('findByEmail')->with('john@example.com')->andReturn(null);
        $repo->shouldReceive('createToken')->with(null)->andReturn(null);

        $useCase = new LoginUserUseCase($repo);
        $dto = new LoginRequestDto('john@example.com', 'secret123');

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('User not found.');
        
        $useCase->execute($dto);
    }
}
