<?php

namespace Bluteki\Ussd\Controls;

use Bluteki\Ussd\Action;
use Bluteki\Ussd\Interfaces\Controls\ResponseActionInterface;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Illuminate\Http\Response;

class ResponseAction extends Action implements ResponseActionInterface
{
    /**
     * Http response.
     * 
     * @var Response response
     */
    private Response $response;

    /**
     * Next following menu.
     * 
     * @var string next
     */
    private string|null $next;

    /**
     * Construct response action menu class.
     * 
     * @param Response response
     * @param string next
     */
    public function __construct(Response $response, string $next = null)
    {
        $this->response = $response;
        $this->next = $next;
    }

    public function action(HandlerInterface &$handler): Response
    {
        $this->appendNextMenu($handler);

        return $this->response;
    }

    /**
     * Append next menu if is set.
     * 
     * @param HandlerInterface handler
     * @return void
     */
    private function appendNextMenu(HandlerInterface &$handler): void
    {
        empty($this->next) ?: ($manager = $handler->session()->manager())->update([
            'menus' => $manager->menus->add($this->next)
        ]);
    }
}