<?php

namespace Tests;

use Mockery;

abstract class ApplicationTestCase extends TestCase
{
    
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    
}