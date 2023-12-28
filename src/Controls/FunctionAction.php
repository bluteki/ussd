<?php

namespace Bluteki\Ussd\Controls;

use Bluteki\Ussd\Action;
use Bluteki\Ussd\Interfaces\Controls\FunctionActionInterface;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Menu;
use Bluteki\Ussd\Models\SessionManager;

class FunctionAction extends Action implements FunctionActionInterface
{
    /**
     * 
     * 
     * @var Menu $menu
     */
    private Menu $menu;

    /**
     * 
     * 
     * @var string $method
     */
    private string $method;

    /**
     * 
     * 
     * @var array $args
     */
    private array $args;

    /**
     * 
     * 
     * @param Menu $menu
     * @param string $method
     */
    public function __construct(Menu $menu, string $method, array $args = [])
    {
        $this->menu = $menu;
        $this->method = $method;
        $this->args = $args;
    }
    
    public function action(HandlerInterface &$handler): NextAction|ResponseAction|FunctionAction
    {
        $this->addMenuToMenusIfNewMenu($handler->session()->manager());

        return call_user_func([$this->menu, $this->method], $this->args);
    }

    /**
     * 
     * 
     * @return void
     */
    protected function addMenuToMenusIfNewMenu(SessionManager $manager): void
    {
        if ($manager->menus->last() == $menu = get_class($this->menu))
            return;
        $manager->update(['menus' => $manager->menus->add($menu)]);
    }
}