<?php

namespace Bluteki\Ussd\Controls;

use Bluteki\Ussd\Action;
use Bluteki\Ussd\Interfaces\Controls\NextActionInterface;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Menu;
use Bluteki\Ussd\Models\SessionManager;

class NextAction extends Action implements NextActionInterface
{
    /**
     * Menu class name.
     * 
     * @var string $menu
     */
    private string $menu;

    /**
     * Construct next action class.
     * 
     * @param string $menu
     */
    public function __construct(string $menu)
    {
        $this->menu = $menu;
    }

    public function action(HandlerInterface &$handler): FunctionAction|NextAction|ResponseAction
    {
        $response = ($menu = new $this->menu($handler))->entry();

        $this->addMenuToMenus($menu, $handler->session()->manager());

        return $response;
    }

    /**
     * Add menu to menus and reset navigation tracker to 1.
     * 
     * @param Menu menu
     * @param SessionManager manager
     * @return void
     */
    protected function addMenuToMenus(Menu $menu, SessionManager $manager): void
    {
        $manager->update([
            'menus' => $manager->menus->add(get_class($menu)),
            'navigation_tracker' => 1
        ]);
    }
}