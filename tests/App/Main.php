<?php

namespace Bluteki\Ussd\Tests\App;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Menu;
use Bluteki\Ussd\Ussd;

class Main extends Menu
{
    public function entry(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::response($this->helper()->continue($this->manager()->value()));
    }

    public function input(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::response($this->helper()->close($this->manager()->value()));
    }
}