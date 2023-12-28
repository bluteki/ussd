<?php

namespace Bluteki\Ussd\Tests\App\FunctionAction;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Menu;
use Bluteki\Ussd\Ussd;

class FunctionActionDemo extends Menu
{
    public const CALLED_FUNCTION_RETURN = "<<<<<<<<--CALLED-->>>>>>>>";

    public function entry(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::response($this->helper()->continue($this->manager()->value()));
    }

    public function input(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::function($this, "option_1");
    }

    public function option_1(): ResponseAction
    {
        return Ussd::response($this->helper()->close(self::CALLED_FUNCTION_RETURN));
    }
}