<?php

namespace Tests;

// use Illuminate\Foundation\Testing\InteractsWithPages;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Database\Seeders\DatabaseSeeder;

abstract class TestCase extends BaseTestCase
{
    // use CreatesApplication, InteractsWithPages;
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }
}
