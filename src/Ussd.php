<?php

namespace Bluteki\Ussd;

use Bluteki\Ussd\Controls\FunctionAction;
use Bluteki\Ussd\Controls\NextAction;
use Bluteki\Ussd\Controls\ResponseAction;
use Bluteki\Ussd\Gateway\Handler;
use Bluteki\Ussd\Interfaces\Controls\FunctionActionInterface;
use Bluteki\Ussd\Interfaces\Controls\NextActionInterface;
use Bluteki\Ussd\Interfaces\Controls\ResponseActionInterface;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Interfaces\Gateway\RequestInterface;
use Bluteki\Ussd\Interfaces\UssdInterface;
use Bluteki\Ussd\Models\SessionManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Ussd implements UssdInterface
{
    public function execute(string $entry_menu, Request $request): Response
    {
        $this->incrementNavigationTracker(
            $manager = ($handler = Handler::getHandler($request))->session()->manager()
        );

        $this->addRequestDataSessionManager($manager, $handler->request());

        $response = $this->callMenuMethod(
            $this->getMenu($manager, $handler, $entry_menu), $manager
        );
        
        while (!($response instanceof ResponseAction)) $response = $response->action($handler);

        return $response->action($handler);
    }

    public static function function(Menu $menu, string $method, array $args = []): FunctionActionInterface
    {
        return new FunctionAction($menu, $method);
    }

    public static function next(string $menu): NextActionInterface
    {
        return new NextAction($menu);
    }

    public static function response(Response $response, string $next = null): ResponseActionInterface
    {
        return new ResponseAction($response, $next);
    }   
    
    protected function incrementNavigationTracker(SessionManager $manager): void
    {
        $manager->update(['navigation_tracker' => $manager->navigation_tracker + 1]);
    }

    protected function addRequestDataSessionManager(SessionManager $manager, RequestInterface $request): void
    {
        $manager->update(['data' => $manager->data->add($request->msg())]);
    }

    protected function getMenu(SessionManager $manager, HandlerInterface &$handler, string $entry_menu): Menu
    {
        if (! empty($last_menu = $manager->menus->last())) return new $last_menu($handler);
        $manager->update(['menus' => $manager->menus->add($entry_menu)]);
        return new $entry_menu($handler);
    }

    protected function is_entry_request(SessionManager $manager): bool
    {
        return $manager->navigation_tracker % 2 != 0;
    }

    protected function throwExceptionIfResponseNotAction($response): void
    {
        $response instanceof FunctionAction ||
        $response instanceof NextAction     || 
        $response instanceof ResponseAction ?: throw new Exception();
    }

    protected function callMenuMethod(Menu $menu, SessionManager $manager): FunctionAction|NextAction|ResponseAction
    {
        $this->throwExceptionIfResponseNotAction(
            $response = $this->is_entry_request($manager) ? $menu->entry() : $menu->input()
        );

        return $response;
    }
}
