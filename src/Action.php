<?php

namespace Bluteki\Ussd;

use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;

abstract class Action
{
    /**
     * 
     * 
     * @param HandlerInterface handler
     * @return mixed
     */
    public abstract function action(HandlerInterface &$handler);
}