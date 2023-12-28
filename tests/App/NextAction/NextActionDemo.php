<?php

namespace Bluteki\Ussd\Tests\App\NextAction;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Menu;
use Bluteki\Ussd\Ussd;

class NextActionDemo extends Menu
{
    public function entry(): FunctionAction|NextAction|ResponseAction
    {
        return Ussd::response($this->helper()->continue($this->manager()->value()));
    }

    public function input(): FunctionAction|NextAction|ResponseAction
    {
        $this->helper()->addData('msisdn', 830483924702934);
        
        return Ussd::next(NextTwoActionDemo::class);
    }
}