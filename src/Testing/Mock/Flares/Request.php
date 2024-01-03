<?php

namespace Bluteki\Ussd\Testing\Mock\Flares;

use Bluteki\Ussd\Interfaces\Testing\Mock\Flares\RequestInterface;
use Illuminate\Http\Request as HttpRequest;

class Request implements RequestInterface
{
    /**
     * Request session id.
     * 
     * @var string sessionID
     */
    private string $sessionID;

    /**
     * Request msisdn.
     * 
     * @var string msisdn
     */
    private string $msisdn;

    /**
     * Request type.
     * 
     * @var int type
     */
    private int $type;

    /**
     * Request input message.
     * 
     * @var string msg
     */
    private string $msg;

    /**
     * Construct request class.
     * 
     * @param string sessionID
     * @param string msisdn
     * @param int type
     * @param string msg
     */
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