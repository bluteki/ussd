<?php

namespace Bluteki\Ussd\Controls;

use Bluteki\Ussd\Action;
use Bluteki\Ussd\Interfaces\Controls\ResponseActionInterface;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Illuminate\Http\Response;

class ResponseAction extends Action implements ResponseActionInterface
{
    /**
     * @var Response response
     */
    private Response $response;

    /**
     * @var string next
     */
    private string|null $next;

    public function __construct(Response $response, string $next = null)
    {
        $this->response = $response;
        $this->next = $next;
    }

    public function action(HandlerInterface &$handler): Response
    {
        empty($this->next) ?: ($manager = $handler->session()->manager())->update([
            'menus' => $manager->menus->add($this->next)
        ]);
        return $this->response;
    }
}