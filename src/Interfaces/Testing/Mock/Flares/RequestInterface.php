<?php

namespace Bluteki\Ussd\Interfaces\Testing\Mock\Flares;

use Bluteki\Ussd\Interfaces\Testing\Mock\HttpRequest;

interface RequestInterface extends HttpRequest
{
    /**
     * Flare request mock.
     * 
     * @return array
     */
    public function request(): array;
}