<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Illuminate\Http\Request;

interface RequestInterface
{
    /**
     * 
     * 
     * @return string
     */
    public function msisdn(): string;

    /**
     * 
     * 
     * @return string
     */
    public function sessionID(): string;

    /**
     * 
     * 
     * @return string|int
     */
    public function type(): string|int;

    /**
     * 
     * 
     * @return string
     */
    public function msg(): string;
}