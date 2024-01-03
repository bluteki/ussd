<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Illuminate\Http\Request;

interface RequestInterface
{
    /**
     * USSD request MSISDN.
     * 
     * @return string
     */
    public function msisdn(): string;

    /**
     * USSD request session ID.
     * 
     * @return string
     */
    public function sessionID(): string;

    /**
     * USSD request type.
     * 
     * @return string|int
     */
    public function type(): string|int;

    /**
     * USSD request input message.
     * 
     * @return string
     */
    public function msg(): string;
}