<?php

namespace Bluteki\Ussd\Gateway;

use Bluteki\Ussd\Interfaces\Gateway\RequestInterface;
use Illuminate\Http\Request as HttpRequest;

abstract class Request implements RequestInterface
{
    public abstract function msisdn(): string;

    public abstract function sessionID(): string;

    public abstract function type(): string|int;

    public abstract function msg(): string;
}