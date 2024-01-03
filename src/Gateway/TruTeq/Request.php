<?php

namespace Bluteki\Ussd\Gateway\TruTeq;

use Bluteki\Ussd\Gateway\Request as GatewayRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class Request extends GatewayRequest
{
    /**
     * Request data.
     * 
     * @var Collection
     */
    private Collection $request;

    private const FIELDS = ['msisdn', 'sessionid', 'type', 'msg'];

    /**
     * Construct request.
     * 
     * @return HttpRequest request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = ($query = collect($request->all()))->has(static::FIELDS) ?
            collect($query) :
            collect((array)(new SimpleXMLElement($request->getContent())));
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