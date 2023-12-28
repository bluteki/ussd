<?php 

namespace Bluteki\Ussd\Interfaces\Testing\Mock;

use Illuminate\Http\Request;

interface HttpRequest
{
    /**
     * 
     * 
     * @return Request
     */
    public function http(): Request;
}