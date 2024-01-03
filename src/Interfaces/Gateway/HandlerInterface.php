<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Bluteki\Ussd\Exceptions\GatewayHandlerNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

interface HandlerInterface
{
    /**
     * Get gateway handler.
     * 
     * @return HandlerInterface
     * @throws GatewayHandlerNotFoundException
     */
    public static function getHandler(Request $request): HandlerInterface;

    /**
     * Added data into shared menus data.
     * 
     * @param string key
     * @param mixed value
     * @return void
     */
    public function addData(string $key, $value): void;

    /**
     * Get database in shared menus data.
     * 
     * @param string key
     * @return Collection|mixed
     */
    public function getData(string $key = null);

    /**
     * Removes data into shared menus data.
     * 
     * @param string key
     * @return void
     */
    public function removeData(string $key): void;

    /**
     * Get ussd request for handler.
     * 
     * @return RequestInterface
     */
    public function request(): RequestInterface;

    /**
     * Get type request.
     * 
     * @return int
     */
    public function type(): int;
    
    /**
     * Continue response for handler.
     * 
     * @param string message
     * @return Response
     */
    public function continue(string $message): Response;

    /**
     * Close response for handler.
     * 
     * @param string message
     * @return Response
     */
    public function close(string $message): Response;

    /**
     * Charge response for handler.
     * 
     * @param string message
     * @param float cost
     * @param string reference
     * @return Response
     */
    public function charge(string $message, float $cost, string $reference = ""): Response;

    /**
     * Get session manager handler.
     * 
     * @return SessionManagerInterface
     */
    public function session(): SessionManagerInterface;
}