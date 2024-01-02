<?php

namespace Bluteki\Ussd\Tests\Future\Gateway;

use Bluteki\Ussd\Exceptions\GatewayHandlerNotFoundException;
use Bluteki\Ussd\Gateway\Flares\Handler as FlaresHandler;
use Bluteki\Ussd\Gateway\Handler;
use Bluteki\Ussd\Gateway\TruTeq\Handler as TruTeqHandler;
use Bluteki\Ussd\Testing\Mock\Flares\Request as FlaresRequest;
use Bluteki\Ussd\Testing\Mock\TruTeq\Request as TruTeqRequest;
use Bluteki\Ussd\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HandlerTest extends TestCase
{
    public function test_get_tru_teq_handler(): void
    {
        $request = new TruTeqRequest(
            $this->faker->randomNumber(),
            $this->faker->phoneNumber(),
            1,
            "*120*180#"
        );

        $this->assertInstanceOf(TruTeqHandler::class, Handler::getHandler($request->http()));
    }

    public function test_get_tru_teq_handler_query(): void
    {
        $request = new TruTeqRequest(
            $this->faker->randomNumber(),
            $this->faker->phoneNumber(),
            1,
            "*120*180#"
        );

        $this->assertInstanceOf(TruTeqHandler::class, Handler::getHandler($request->http_query()));
    }

    public function test_get_flares_handler(): void
    {
        $request = new FlaresRequest(
            $this->faker->randomNumber(),
            $this->faker->phoneNumber(),
            1,
            "120*180"
        );

        $this->assertInstanceOf(FlaresHandler::class, Handler::getHandler(
            Request::create("?" . http_build_query($request->request()), "POST", [], [], [], [], "")
        ));
    }

    public function test_throw_gateway_not_found_exception_when_gateway_does_not_exist(): void
    {
        $this->expectException(GatewayHandlerNotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        Handler::getHandler(Request::create('', 'POST'));
    }
}
