<?php

namespace Bluteki\Ussd\Interfaces;

use Bluteki\Ussd\Interfaces\Controls\FunctionActionInterface;
use Bluteki\Ussd\Interfaces\Controls\NextActionInterface;
use Bluteki\Ussd\Interfaces\Controls\ResponseActionInterface;
use Bluteki\Ussd\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface UssdInterface
{
    /**
     * Execute USSD menu navigation..
     * 
     * @param Request request
     * @return Response
     */
    public function execute(string $menu, Request $request): Response;

    /**
     * Create function action.
     * 
     * @param Menu menu
     * @param string method
     * @param array args
     * @return FunctionActionInterface
     */
    public static function function(Menu $menu, string $method, array $args = []): FunctionActionInterface;

    /**
     * Create next action.
     * 
     * @param string menu
     * @return NextActionInterface
     */
    public static function next(string $menu): NextActionInterface;

    /**
     * Create response action.
     * 
     * @param Response response
     * @param string|null next
     * @return ResponseActionInterface
     */
    public static function response(Response $response, string $next = null): ResponseActionInterface;
}