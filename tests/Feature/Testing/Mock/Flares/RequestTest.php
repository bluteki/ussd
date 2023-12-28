<?php

namespace Bluteki\Ussd\Tests\Future\Testing\Mock\Flares;

use Bluteki\Ussd\Testing\Mock\Flares\Request;
use Bluteki\Ussd\Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * @var string sessionID
     */
    private string $sessionID;

    /**
     * @var string msisdn
     */
    private string $msisdn;

    /**
     * @var int type
     */
    private int $type;

    /**
     * @var string msg
     */
    private string $msg;

    /**
     * @var Request request
     */
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Request(
            $this->sessionID = (string) $this->faker->randomNumber(5),
            $this->msisdn = $this->faker->e164PhoneNumber(),
            $this->type = 1,
            $this->msg = "120*180"
        );
    }

    public function test_flares_request(): void
    {
        $this->assertEquals([
            "msisdn" => $this->msisdn,
            "sessionid" => $this->sessionID,
            "type" => $this->type,
            "msg" => $this->msg
        ], $this->request->request());
    }

    public function test_flares_http_request(): void
    {
        $this->assertEquals($this->request->request(), $this->request->http()->request->all());
    }
}