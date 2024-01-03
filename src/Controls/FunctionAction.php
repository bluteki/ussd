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
     * Menu class.
     * 
     * @var Menu $menu
     */
    private Menu $menu;

    /**
     * Method to be called menu.
     * 
     * @var string $method
     */
    private string $method;

    /**
     * Arguments to be passed method.
     * 
     * @var array $args
     */
    private array $args;

    /**
     * Construct function action class.
     * 
     * @param Menu $menu
     * @param string $method
     * @param array args
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
     * Add menu to menus if not current menu action.
     * 
     * @return void
     */
    protected function addMenuToMenusIfNewMenu(SessionManager $manager): void
    {
        $manager->menus->last() == ($menu = get_class($this->menu)) ?: $manager->update([
            'menus' => $manager->menus->add($menu)
        ]);
    }
}