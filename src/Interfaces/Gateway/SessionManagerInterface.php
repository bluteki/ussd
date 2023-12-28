<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Bluteki\Ussd\Models\SessionManager;

interface SessionManagerInterface
{
    /**
     * 
     * 
     * @return SessionManager
     */
    public function manager(): SessionManager;

    /**
     * 
     * 
     * @return string|int
     */
    public function value(): string|int;

    /**
     * 
     * 
     * @param HandlerInterface $request
     * @return SessionManagerInterface
     */
    public static function getInstance(HandlerInterface $request): SessionManagerInterface;
}