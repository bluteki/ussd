<?php

namespace Bluteki\Ussd\Gateway\Flares;

use Bluteki\Ussd\Gateway\Request as GatewayRequest;
use Illuminate\Http\Request as HttpRequest;

class Request extends GatewayRequest
{
    /**
     * Http request.
     * 
     * @var HttpRequest request
     */
    private HttpRequest $request;

    /**
     * Construct request.
     * 
     * @param HttpRequest request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }
    
    public function msisdn(): string
    {
        return $this->request->get('msisdn');
    }

    public function sessionID(): string
    {
        return $this->request->get('sessionid');
    }

    public function type(): string|int
    {
        return $this->request->get('type');
    }

    public function msg(): string
    {
        return $this->request->get('msg');
    }
}