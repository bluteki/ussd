<?php

namespace Bluteki\Ussd\Interfaces\Testing\Mock\TruTeq;

use Bluteki\Ussd\Interfaces\Testing\Mock\HttpRequest;

interface RequestInterface extends HttpRequest
{
    /**
     * 
     * 
     * @return string
     */
    public function xml(): string;
}