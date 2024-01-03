<?php

namespace Bluteki\Ussd\Gateway\TruTeq;

use DOMDocument;
use DOMElement;
use Bluteki\Ussd\Gateway\Handler as GatewayHandler;
use Bluteki\Ussd\Gateway\Request as GatewayRequest;
use Bluteki\Ussd\Gateway\TruTeq\Request as TruTeqRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends GatewayHandler
{
    public const USSD_REQUEST_NEW_REQUEST        = 1;
    public const USSD_REQUEST_EXISTING_SESSION   = 2;
    public const USSD_REQUEST_SESSION_CANCELLED  = 3;  // WILL INCLUDE WHEN REQUIRED BY PROJECT
    public const USSD_REQUEST_SESSION_TIMED_OUT  = 4;  // WILL INCLUDE WHEN REQUIRED BY PROJECT
    public const USSD_REQUEST_RATE_CHARGE_FAILED = 10; // WILL INCLUDE WHEN REQUIRED BY PROJECT
    public const USSD_RESPONSE_OPEN_SESSION      = 2;
    public const USSD_RESPONSE_CLOSE_SESSION     = 3;
    public const USSD_RESPONSE_REDIRECT          = 5;
    
    private const HTTP_USER_AGENT = 'com.truteq.net.http.Connection';

    /**
     * TruTeq ussd request.
     * 
     * @var TruTeqRequest ussd_request
     */
    private TruTeqRequest $ussd_request;

    public static function is_valid_handler(Request $request): bool
    {
        return $request->server->get('HTTP_USER_AGENT') == static::HTTP_USER_AGENT;
    }

    public function request(): GatewayRequest
    {
        return isset($this->ussd_request) ?
            $this->ussd_request :
            $this->ussd_request = new TruTeqRequest($this->request);
    }

    public function type(): int
    {
        return match((int)$this->request()->type()) {
            static::USSD_REQUEST_NEW_REQUEST      => static::REQUEST_TYPE_NEW,
            static::USSD_REQUEST_EXISTING_SESSION => static::REQUEST_TYPE_EXISTING,
            default                               => static::REQUEST_TYPE_CLOSE
        };
    }

    public function continue(string $message): Response
    {
        return $this->response(static::USSD_RESPONSE_OPEN_SESSION, $message);
    }

    public function close(string $message): Response
    {
        return $this->response(static::USSD_RESPONSE_CLOSE_SESSION, $message);
    }

    public function charge(string $message, float $cost, string $reference = ''): Response
    {
        return $this->response(static::USSD_RESPONSE_OPEN_SESSION, $message, $cost, $reference);
    }

    /**
     * Response generator.
     * 
     * @param int type
     * @param string msg
     * @param float cost
     * @param string reference
     * @return Response
     */
    private function response(int $type, string $msg, float $cost = 0.0, string $reference = ''): Response
    {
        $xml = new DOMDocument('1.0', 'UTF-8');

        $xml->appendChild($ussd = $xml->createElement('ussd')); // USSD ROOT
        $ussd->appendChild($xml->createElement("type", $type));
        $ussd->appendChild($xml->createElement("msg", $msg));

        $cost <= 0 ?: $this->appendPremiumCostToUssd($xml, $ussd, $cost, $reference);

        return response($xml->saveXML());
    }

    /**
     * Append ussd request cost in XML document.
     * 
     * @param DOMDocument xml
     * @param DOMElement ussd
     * @param float cost
     * @param string reference
     * @return void
     */
    private function appendPremiumCostToUssd(DOMDocument &$xml, DOMElement &$ussd, float $cost, string $reference): void
    {
        $ussd->appendChild($premium = $xml->createElement("premium"));
        $premium->append($xml->createElement('cost', $cost));
        $premium->append($xml->createElement('ref', $reference));
    }
}