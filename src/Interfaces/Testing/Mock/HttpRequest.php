<?php 

namespace Bluteki\Ussd\Interfaces\Testing\Mock;

use Illuminate\Http\Request;

interface HttpRequest
{
    /**
     * Http request mock.
     * 
     * @return Request
     */
    public function http(): Request;
}