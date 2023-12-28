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
     * 
     * 
     * @param Request request
     * @return Response
     */
    public function execute(string $menu, Request $request): Response;

    /**
     * 
     * 
     * @return FunctionActionInterface
     */
    public static function function(Menu $menu, string $method, array $args = []): FunctionActionInterface;

    /**
     * 
     * 
     * @return NextActionInterface
     */
    public static function next(string $menu): NextActionInterface;

    /**
     * 
     * 
     * @return ResponseActionInterface
     */
    public static function response(Response $response, string $next = null): ResponseActionInterface;
}