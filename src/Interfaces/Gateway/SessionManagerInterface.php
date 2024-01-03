<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Bluteki\Ussd\Models\SessionManager;

interface SessionManagerInterface
{
    /**
     * Get session manger model.
     * 
     * @return SessionManager
     */
    public function manager(): SessionManager;

    /**
     * Get current input value.
     * 
     * @return string|int
     */
    public function value(): string|int;

    /**
     * Get or Create session manager instance.
     * 
     * @param HandlerInterface $request
     * @return SessionManagerInterface
     */
    public static function getInstance(HandlerInterface $request): SessionManagerInterface;
}