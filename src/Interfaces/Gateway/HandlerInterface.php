<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Bluteki\Ussd\Exceptions\GatewayHandlerNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

interface HandlerInterface
{
    /**
     * 
     * 
     * @return HandlerInterface
     * @throws GatewayHandlerNotFoundException
     */
    public static function getHandler(Request $request): HandlerInterface;

    /**
     * 
     * 
     * @param string key
     * @param mixed value
     * @return void
     */
    public function addData(string $key, $value): void;

    /**
     * 
     * 
     * @param string key
     * @return Collection|mixed
     */
    public function getData(string $key = null);

    /**
     * 
     * 
     * @param string key
     * @return void
     */
    public function removeData(string $key): void;

    /**
     * 
     * 
     * @return RequestInterface
     */
    public function request(): RequestInterface;

    /**
     * 
     * 
     * @return int
     */
    public function type(): int;
    
    /**
     * 
     * 
     * @param string message
     * @return Response
     */
    public function continue(string $message): Response;

    /**
     * 
     * 
     * @param string message
     * @return Response
     */
    public function close(string $message): Response;

    /**
     * 
     * 
     * @param string message
     * @param float cost
     * @param string reference
     * @return Response
     */
    public function charge(string $message, float $cost, string $reference = ""): Response;

    /**
     * 
     * 
     * @return SessionManagerInterface
     */
    public function session(): SessionManagerInterface;
}