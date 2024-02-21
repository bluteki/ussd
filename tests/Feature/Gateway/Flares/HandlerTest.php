<?php

namespace Bluteki\Ussd\Tests\Future\Gateway\Flares;

use Bluteki\Ussd\Gateway\Flares\Handler;
use Bluteki\Ussd\Gateway\Flares\Request as FlaresRequest;
use Bluteki\Ussd\Models\SessionManager;
use Bluteki\Ussd\Testing\Mock\Flares\Request as RequestMock;
use Bluteki\Ussd\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HandlerTest extends TestCase
{
    public function test_is_valid_handler(): void
    {
        $this->assertTrue(Handler::is_valid_handler((new RequestMock(
            $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            Handler::USSD_REQUEST_NEW_REQUEST,
            "120*180"
        ))->http()));
        $this->assertFalse(Handler::is_valid_handler(Request::create("", "POST")));
    }

    public function test_request(): void
    {
        $this->assertEquals(new FlaresRequest($request = (new RequestMock(
            $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            Handler::USSD_REQUEST_NEW_REQUEST,
            "120*180"
        ))->http()), (new Handler($request))->request());
    }

    public function test_continue(): void
    {
        $handler = new Handler((new RequestMock(
            $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            Handler::USSD_REQUEST_NEW_REQUEST,
            "120*180"
        ))->http());

        $response = $handler->continue($msg = $this->faker->words(5, true));
        
        $this->assertEquals($msg, $response->getContent());
        $this->assertEquals(Handler::USSD_RESPONSE_CONTINUE, $response->headers->get("FreeFlow"));
        $this->assertEquals('N', $response->headers->get("Charge"));
        $this->assertEquals('', $response->headers->get("CpRefId"));
        $this->assertEquals(0, $response->headers->get("Amount"));
        $this->assertEquals('UTF-8', $response->headers->get("Content-Type"));        
    }

    public function test_close(): void
    {
        SessionManager::insert([
            'session_id' => $sessionID = $this->faker->randomNumber(5),
            'msisdn' => $msisdn = $this->faker->e164PhoneNumber(),
        ]);

        $handler = new Handler((new RequestMock(
            $sessionID,
            $msisdn,
            Handler::USSD_REQUEST_NEW_REQUEST,
            "120*180"
        ))->http());
        
        $response = $handler->close($msg = $this->faker->words(5, true));
        
        $this->assertEquals($msg, $response->getContent());
        $this->assertEquals(Handler::USSD_RESPONSE_BREAK, $response->headers->get("FreeFlow"));
        $this->assertEquals('N', $response->headers->get("Charge"));
        $this->assertEquals('', $response->headers->get("CpRefId"));
        $this->assertEquals(0, $response->headers->get("Amount"));
        $this->assertEquals('UTF-8', $response->headers->get("Content-Type"));

        $this->assertDatabaseMissing('session_managers', [
            'session_id' => $sessionID,
            'msisdn' => $msisdn,
        ]);
    }

    public function test_charge(): void
    {
        $handler = new Handler((new RequestMock(
            $this->faker->randomNumber(5),
            $this->faker->e164PhoneNumber(),
            Handler::USSD_REQUEST_NEW_REQUEST,
            "120*180"
        ))->http());

        $response = $handler->charge(
            $msg = $this->faker->words(5, true),
            $amount = 10.51,
            $reference = Str::random(26)
        );
        
        $this->assertEquals($msg, $response->getContent());
        $this->assertEquals(Handler::USSD_RESPONSE_CONTINUE, $response->headers->get("FreeFlow"));
        $this->assertEquals('Y', $response->headers->get("Charge"));
        $this->assertEquals($reference, $response->headers->get("CpRefId"));
        $this->assertEquals($amount, $response->headers->get("Amount"));
        $this->assertEquals('UTF-8', $response->headers->get("Content-Type"));
    }
}