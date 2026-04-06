<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\TestDbSetup;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use TestDbSetup;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure minimal tables/seed required by view composers are present
        $this->ensureBasicTables();
    }
}
