<?php

namespace Bluteki\Ussd\Tests;

use Bluteki\Ussd\UssdServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use \Orchestra\Testbench\TestCase as BaseTest;

class TestCase extends BaseTest
{
    use DatabaseMigrations,
        WithFaker;
    
    protected function setUp(): void
    {
        parent::setUp();
    }
  
    protected function getPackageProviders($app)
    {
        return [
            UssdServiceProvider::class,
        ];
    }
  
    protected function getEnvironmentSetUp($app)
    {
      // perform environment setup
    }
}