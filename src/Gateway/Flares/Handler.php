<?php

namespace Bluteki\Ussd\Gateway\Flares;

use Bluteki\Ussd\Gateway\Flares\Request as FlaresRequest;
use Bluteki\Ussd\Gateway\Handler as GatewayHandler;
use Bluteki\Ussd\Gateway\Request as GatewayRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends GatewayHandler
{
    public const USSD_REQUEST_NEW_REQUEST      = 1;
    public const USSD_REQUEST_EXISTING_REQUEST = 0;
    public const USSD_RESPONSE_CONTINUE        = 'FC';
    public const USSD_RESPONSE_BREAK           = 'FB';

    private const FIELDS = ['msisdn', 'sessionid', 'type', 'msg'];

    /**
     * @var FlaresRequest ussd_request
     */
    private FlaresRequest $ussd_request;

    public static function is_valid_handler(Request $request): bool
    {
        return collect($request->request->all())->has(self::FIELDS);
    }

    public function request(): GatewayRequest
    {
        return isset($this->ussd_request) ?
            $this->ussd_request :
            $this->ussd_request = new FlaresRequest($this->request);
    }

    public function type(): int
    {
        return match ((int)$this->request()->type()) {
            static::USSD_REQUEST_NEW_REQUEST      => static::REQUEST_TYPE_NEW,
            static::USSD_REQUEST_EXISTING_REQUEST => static::REQUEST_TYPE_EXISTING,
            default                               => static::REQUEST_TYPE_CLOSE
        };
    }

    public function continue(string $message): Response
    {
        return $this->response(Handler::USSD_RESPONSE_CONTINUE, $message);
    }

    public function close(string $message): Response
    {
        return $this->response(Handler::USSD_RESPONSE_BREAK, $message);
    }

    public function charge(string $message, float $cost, string $reference = ''): Response
    {
        return $this->response(Handler::USSD_RESPONSE_CONTINUE, $message, $cost, $reference);
    }

    private function response(string $type, string $message, float $cost = 0.0, string $reference = ''): Response
    {
        return response($message)->header('FreeFlow', $type)
                                 ->header('Charge', $cost > 0 ? 'Y' : 'N')
                                 ->header('CpRefId', $reference)
                                 ->header('Amount', $cost)
                                 ->header('Content-Type', 'UTF-8');
    }
}
