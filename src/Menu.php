<?php

namespace Bluteki\Ussd;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Interfaces\Gateway\SessionManagerInterface;
use Bluteki\Ussd\Interfaces\MenuInterface;

abstract class Menu implements MenuInterface
{
    /**
     * Gateway handler.
     * 
     * @var HandlerInterface handler
     */
    private HandlerInterface $handler;
    
    /**
     * Construct menu class.
     * 
     * @var HandlerInterface handler
     */
    public function __construct(HandlerInterface &$handler)
    {
        $this->handler = $handler;
    }

    public abstract function entry(): FunctionAction|NextAction|ResponseAction;

    public abstract function input(): FunctionAction|NextAction|ResponseAction; 

    /**
     * Get handler.
     * 
     * @return HandlerInterface
     */
    protected function helper(): HandlerInterface
    {
        return $this->handler;
    }

    /**
     * Get session manager.
     * 
     * @return SessionManagerInterface
     */
    protected function manager(): SessionManagerInterface
    {
        return $this->handler->session();
    }
}