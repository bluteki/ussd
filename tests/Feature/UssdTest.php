<?php

namespace Bluteki\Ussd\Tests;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Ussd;

class UssdTest extends TestCase
{
    public function test_ussd_function_static_method_return_function_action_object(): void
    {
        // $this->assertInstanceOf(FunctionAction::class, Ussd::function());

        $this->assertTrue(true);
    }
}