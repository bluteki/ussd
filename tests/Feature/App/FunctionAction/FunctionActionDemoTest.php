<?php

namespace Bluteki\Ussd\Tests\Future\App;

use Bluteki\Ussd\Gateway\TruTeq\Handler;
use Bluteki\Ussd\Testing\Mock\TruTeq\Request;
use Bluteki\Ussd\Tests\App\FunctionAction\FunctionActionDemo;
use Bluteki\Ussd\Tests\TestCase;
use Bluteki\Ussd\Ussd;
use SimpleXMLElement;

class FunctionActionDemoTest extends TestCase
{
    public function test_navigate_response_action_demo(): void
    {
        $response_entry = (new Ussd)->execute(FunctionActionDemo::class, (new Request(
            $sessionID = $this->faker->randomNumber(5),
            $msisdn = $this->faker->e164PhoneNumber(),
            Request::USSD_REQUEST_NEW_REQUEST,
            $msg_entry = "*120*180#"
        ))->http());

        $response_entry_data = collect((array)(new SimpleXMLElement($response_entry->getContent())));

        $this->assertEquals(Handler::USSD_RESPONSE_OPEN_SESSION, $response_entry_data->get('type'));
        $this->assertEquals($msg_entry, $response_entry_data->get('msg'));

        $response_input = (new Ussd)->execute(FunctionActionDemo::class, (new Request(
            $sessionID,
            $msisdn,
            Request::USSD_REQUEST_EXISTING_SESSION,
            $this->faker->words(10, true)
        ))->http());

        $response_input_data = collect((array)(new SimpleXMLElement($response_input->getContent())));

        $this->assertEquals(Handler::USSD_RESPONSE_CLOSE_SESSION, $response_input_data->get('type'));
        $this->assertEquals(FunctionActionDemo::CALLED_FUNCTION_RETURN, $response_input_data->get('msg'));
    }
}