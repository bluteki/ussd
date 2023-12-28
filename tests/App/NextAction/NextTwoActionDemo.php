<?php

namespace Bluteki\Ussd\Tests\App\NextAction;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Menu;
use Bluteki\Ussd\Ussd;

class NextTwoActionDemo extends Menu
{
    public const INPUT_NEXT_TWO_ACTION_RESPONSE = "<<<< -- NextTwoActionDemo -- >>>>";

    public function entry(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::response($this->helper()->continue($this->manager()->value()));
    }

    public function input(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::response($this->helper()->close(static::INPUT_NEXT_TWO_ACTION_RESPONSE));
    }
}