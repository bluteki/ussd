<?php

namespace Bluteki\Ussd\Interfaces\Testing\Mock\TruTeq;

use Bluteki\Ussd\Interfaces\Testing\Mock\HttpRequest;
use Illuminate\Http\Request;

interface RequestInterface extends HttpRequest
{
    /**
     * TruTeq XML request mock.
     * 
     * @return string
     */
    public function xml(): string;

    /**
     * TruTeq request mock with query parameter.
     * 
     * @return Request
     */
    public function http_query(): Request;
}