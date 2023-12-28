<?php

namespace Bluteki\Ussd\Tests\Future\Testing;

use Bluteki\Ussd\Testing\TestCase as MainTestCase;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PHPUnit\Framework\TestCase;


class TestCaseTest extends TestCase
{
    public function test_ussd_test_case_extends_orchestra_testbench_test_case(): void
    {
        $this->assertInstanceOf(BaseTestCase::class, $test_case = new MainTestCase($name = "testing"));
        $this->assertEquals($name, $test_case->name());
    }
}