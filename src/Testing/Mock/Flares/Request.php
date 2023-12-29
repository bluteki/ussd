<?php

namespace Bluteki\Ussd\Testing\Mock\Flares;

use Bluteki\Ussd\Interfaces\Testing\Mock\Flares\RequestInterface;
use Illuminate\Http\Request as HttpRequest;

class Request implements RequestInterface
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

    public function __construct(string $sessionID, string $msisdn, int $type, string $msg)
    {
        $this->sessionID = $sessionID;
        $this->msisdn = $msisdn;
        $this->type = $type;
        $this->msg = $msg;
    }

    public function request(): array
    {
        return [
            'msisdn' => $this->msisdn,
            'sessionid' => $this->sessionID,
            'type' => $this->type,
            'msg' => $this->msg
        ];
    }

    public function http(): HttpRequest
    {
        return HttpRequest::create("?" . http_build_query($this->request()), "POST");
    }
}