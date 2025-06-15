<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}