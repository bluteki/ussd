<?php

namespace Bluteki\Ussd\Tests\Future\Gateway\Flares;

use Bluteki\Ussd\Gateway\Flares\Request;
use Bluteki\Ussd\Testing\Mock\Flares\Request as RequestMock;
use Bluteki\Ussd\Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * @var string msisdn
     */
    private string $msisdn;

    /**
     * @var string sessionID
     */
    private string $sessionID;

    /**
     * @var string type
     */
    private int $type;

    /**
     * @var string message
     */
    private string $msg;

    /**
     * @var Request request
     */
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Request((new RequestMock(
            $this->sessionID = $this->faker->randomNumber(5),
            $this->msisdn = $this->faker->e164PhoneNumber(),
            $this->type = 1,
            $this->msg = $this->faker->words(3, true)
        ))->http());
    }

    public function test_get_msisdn(): void
    {
        $this->assertEquals($this->msisdn, $this->request->msisdn());
    }

    public function test_get_session_id(): void
    {
        $this->assertEquals($this->sessionID, $this->request->sessionID());
    }

    public function test_get_type(): void
    {
        $this->assertEquals($this->type, $this->request->type());
    }

    public function test_get_msg(): void
    {
        $this->assertEquals($this->msg, $this->request->msg());
    }
}