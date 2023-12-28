<?php

namespace Bluteki\Ussd\Contacts;

use Bluteki\Ussd\Interfaces\Controls\FunctionActionInterface;
use Bluteki\Ussd\Interfaces\Controls\NextActionInterface;
use Bluteki\Ussd\Interfaces\Controls\ResponseActionInterface;

interface MenuInterface
{
    /**
     * 
     * 
     * @return FunctionActionInterface|NextActionInterface|ResponseActionInterface
     */
    public function main(): FunctionActionInterface|NextActionInterface|ResponseActionInterface;

    /**
     * 
     *  
     * @return array
     */
    public function options(): array;
}