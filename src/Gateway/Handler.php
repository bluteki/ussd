<?php

namespace Bluteki\Ussd\Gateway;

use Bluteki\Ussd\Exceptions\GatewayHandlerNotFoundException;
use Bluteki\Ussd\Gateway\Request as GatewayRequest;
use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Interfaces\Gateway\SessionManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

abstract class Handler implements HandlerInterface
{
    public const REQUEST_TYPE_NEW           = 100;
    public const REQUEST_TYPE_EXISTING      = 103;
    public const REQUEST_TYPE_CLOSE         = 106;
    public const REQUEST_TYPE_CHARGE        = 109;
    public const REQUEST_TYPE_CHARGE_FAILED = 112;
    public const REQUEST_TYPE_REDIRECT      = 115;
    public const REQUEST_TYPE_TIME_OUT      = 118;
    public const RESPONSE_TYPE_CONTINUE     = 200;
    public const RESPONSE_TYPE_CLOSE        = 203;

    /**
     * @var Request request
     */
    protected Request $request;

    /**
     * @var SessionManagerInterface manager
     */
    private SessionManagerInterface $manager;

    /**
     * @var Collection data
     */
    private Collection $data;

    /**
     * 
     * 
     * @param Request request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        // static::$data = isset(static::$data) ? static::$data : collect();
        $this->data = collect();
    }
    
    public static function getHandler(Request $request): HandlerInterface
    {
        foreach (config('ussd.handlers', []) as $handler)
            if ($handler::is_valid_handler($request))
                return new $handler($request);
        return throw new GatewayHandlerNotFoundException(
            "Gateway handler not found", Response::HTTP_NOT_FOUND
        );
    }

    public function addData(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function getData(string $key = null)
    {
        return is_null($key) ? $this->data : $this->data->get($key);
    }

    public function removeData(string $key): void
    {
        unset($this->data[$key]);
    }

    public abstract static function is_valid_handler(Request $request): bool;

    public abstract function request(): GatewayRequest;

    public abstract function type(): int;

    public abstract function continue(string $message): Response;

    public abstract function close(string $message): Response;

    public abstract function charge(string $message, float $cost, string $reference = ""): Response;

    public function session(): SessionManagerInterface
    {
        return isset($manager) ? $this->manager : $this->manager = new SessionManager($this);
    }
}