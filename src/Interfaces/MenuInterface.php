<?php

namespace Bluteki\Ussd\Interfaces;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;

interface MenuInterface
{
    /**
     * Menu entry.
     * 
     * @return FunctionAction|NextAction|ResponseAction
     */
    public function entry(): FunctionAction|NextAction|ResponseAction;

    /**
     * Menu input.
     * 
     * @return FunctionAction|NextAction|ResponseAction
     */
    public function input(): FunctionAction|NextAction|ResponseAction; 
}