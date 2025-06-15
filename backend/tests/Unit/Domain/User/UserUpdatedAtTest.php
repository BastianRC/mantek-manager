<?php

namespace Tests\Unit\Domain\User;

use DateTimeImmutable;
use InvalidArgumentException;
use Src\User\Domain\ValueObject\UserUpdatedAt;
use Tests\UnitTestCase;

class UserUpdatedAtTest extends UnitTestCase
{
    public function test_user_updated_created_at_is_created_when_passed_valid_string()
    {
        $date = new UserUpdatedAt('2024-01-01 12:34:56');

        $this->assertInstanceOf(UserUpdatedAt::class, $date);
        $this->assertEquals('2024-01-01 12:34:56', $date->toString());
    }

    public function test_user_updated_at_is_created_when_passed_datetime_immutable()
    {
        $now = new DateTimeImmutable('2023-12-31 10:00:00');
        $date = new UserUpdatedAt($now);

        $this->assertEquals('2023-12-31 10:00:00', $date->toString());
    }

    public function test_user_updated_at_is_created_when_no_value_is_passed()
    {
        $date = new UserUpdatedAt();

        $this->assertInstanceOf(DateTimeImmutable::class, $date->value());
        $this->assertNotEmpty($date->toString());
    }

    public function test_user_updated_at_throws_exception_when_passed_invalid_string()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Date');

        new UserUpdatedAt('not-a-date');
    }

    public function test_user_updated_at_equals_returns_true_when_values_are_equal()
    {
        $date1 = new UserUpdatedAt('2024-04-15 00:00:00');
        $date2 = new UserUpdatedAt('2024-04-15 00:00:00');

        $this->assertTrue($date1->equals($date2));
    }

    public function test_user_updated_at_equals_returns_false_when_values_are_different()
    {
        $date1 = new UserUpdatedAt('2024-04-15 00:00:00');
        $date2 = new UserUpdatedAt('2023-01-01 00:00:00');

        $this->assertFalse($date1->equals($date2));
    }
}
