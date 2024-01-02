<?php

namespace Bluteki\Ussd\Interfaces\Testing\Mock\TruTeq;

use Bluteki\Ussd\Interfaces\Testing\Mock\HttpRequest;
use Illuminate\Http\Request;

interface RequestInterface extends HttpRequest
{
    /**
     * 
     * 
     * @return string
     */
    public function xml(): string;

    /**
     * 
     * 
     * @return Request
     */
    public function http(): Request;

    /**
     * 
     * 
     * @return Request
     */
    public function http_query(): Request;
}