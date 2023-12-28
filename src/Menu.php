<?php

namespace Bluteki\Ussd;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Interfaces\Gateway\SessionManagerInterface;

abstract class Menu
{
    /**
     * @var HandlerInterface handler
     */
    private HandlerInterface $handler;
    
    /**
     * @var HandlerInterface handler
     */
    public function __construct(HandlerInterface &$handler)
    {
        $this->handler = $handler;
    }

    /**
     * 
     * 
     * @return FunctionAction|NextAction|ResponseAction
     */
    public abstract function entry(): FunctionAction|NextAction|ResponseAction;

    /**
     * 
     * 
     * @return FunctionAction|NextAction|ResponseAction
     */
    public abstract function input(): FunctionAction|NextAction|ResponseAction; 

    /**
     * 
     * 
     * @return HandlerInterface
     */
    protected function helper(): HandlerInterface
    {
        return $this->handler;
    }

    /**
     * 
     * 
     * @return SessionManagerInterface
     */
    protected function manager(): SessionManagerInterface
    {
        return $this->handler->session();
    }
}