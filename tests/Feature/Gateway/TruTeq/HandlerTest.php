<?php

namespace Bluteki\Ussd\Tests\Future\Gateway\TruTeq;

use Bluteki\Ussd\Gateway\TruTeq\Handler;
use Bluteki\Ussd\Testing\Mock\TruTeq\Request as RequestMock;
use Bluteki\Ussd\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleXMLElement;

class HandlerTest extends TestCase
{
    public function test_is_valid_handler(): void
    {
        $this->assertTrue(Handler::is_valid_handler((new RequestMock(
            (string) $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ))->http()));
        $this->assertFalse(Handler::is_valid_handler(Request::create("", "POST")));
    }

    public function test_request(): void
    {
        $request = (new Handler((new RequestMock(
            $sessionID = (string) $this->faker->randomNumber(5),
            $msisdn = $this->faker->e164PhoneNumber(),
            $type = 1,
            $msg = "*120*180#"
        ))->http()))->request();

        $this->assertEquals($sessionID, $request->sessionID());
        $this->assertEquals($msisdn, $request->msisdn());
        $this->assertEquals($type, $request->type());
        $this->assertEquals($msg, $request->msg());
    }

    public function test_continue(): void
    {
        $handler = new Handler((new RequestMock(
            (string) $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ))->http());

        $data = collect(
            (array)(new SimpleXMLElement($handler->continue($msg = $this->faker->words(4, true))->getContent()))
        );

        $this->assertEquals(Handler::USSD_RESPONSE_OPEN_SESSION, $data->get("type"));     
        $this->assertEquals($msg, $data->get("msg"));     
    }

    public function test_close(): void
    {
        $handler = new Handler((new RequestMock(
            (string) $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ))->http());

        $data = collect(
            (array)(new SimpleXMLElement($handler->close($msg = $this->faker->words(4, true))->getContent()))
        );

        $this->assertEquals(Handler::USSD_RESPONSE_CLOSE_SESSION, $data->get("type"));     
        $this->assertEquals($msg, $data->get("msg")); 
    }

    public function test_charge(): void
    {
        $handler = new Handler((new RequestMock(
            (string) $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            1,
            "*120*180#"
        ))->http());

        $msg = $this->faker->words(4, true);
        $cost = .55;
        $reference = Str::random(26);
        $data = collect(
            (array)(new SimpleXMLElement($handler->charge($msg, $cost, $reference)->getContent()))
        );

        $this->assertEquals(Handler::USSD_RESPONSE_OPEN_SESSION, $data->get("type"));     
        $this->assertEquals($msg, $data->get("msg"));

        $premium = collect((array)$data->get("premium"));

        $this->assertEquals($cost, $premium->get("cost"));
        $this->assertEquals($reference, $premium->get("ref"));
    }
}