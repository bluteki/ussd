<?php

namespace Bluteki\Ussd\Testing\Mock\TruTeq;

use DOMDocument;
use Bluteki\Ussd\Interfaces\Testing\Mock\TruTeq\RequestInterface;
use Illuminate\Http\Request as HttpRequest;

class Request implements RequestInterface
{
    public const USSD_REQUEST_NEW_REQUEST        = 1;
    public const USSD_REQUEST_EXISTING_SESSION   = 2;
    public const USSD_REQUEST_SESSION_CANCELLED  = 3;
    public const USSD_REQUEST_SESSION_TIMED_OUT  = 4;
    public const USSD_REQUEST_RATE_CHARGE_FAILED = 10;

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

    public function xml(): string
    {
        $xml = new DOMDocument('1.0', 'UTF-8');

        $xml->appendChild($ussd = $xml->createElement('ussd')); // USSD ROOT
        $ussd->appendChild($xml->createElement('msisdn', $this->msisdn));
        $ussd->appendChild($xml->createElement('sessionid', $this->sessionID));
        $ussd->appendChild($xml->createElement('type', $this->type));
        $ussd->appendChild($xml->createElement('msg', $this->msg));

        return $xml->saveXML();
    }

    public function http(): HttpRequest
    {
        return HttpRequest::create(
            '',
            'POST',
            [],
            [],
            [],
            ['HTTP_USER_AGENT' => 'com.truteq.net.http.Connection'],
            $this->xml()
        );
    }
    
    public function http_query(): HttpRequest
    {
        return HttpRequest::create(
            "?" . http_build_query([
                'sessionid' => $this->sessionID,
                'msisdn' => $this->msisdn,
                'type' => $this->type,
                'msg' => $this->msg
            ]),
            'GET',
            [],
            [],
            [],
            ['HTTP_USER_AGENT' => 'com.truteq.net.http.Connection'],
        );
    }
}
