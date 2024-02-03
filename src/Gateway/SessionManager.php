<?php

namespace Bluteki\Ussd\Gateway;

use Bluteki\Ussd\Interfaces\Gateway\HandlerInterface;
use Bluteki\Ussd\Interfaces\Gateway\SessionManagerInterface;
use Bluteki\Ussd\Models\SessionManager as Model;

class SessionManager implements SessionManagerInterface
{
    /**
     * Session manager.
     * 
     * @var SessionManagerInterface $instance
     */
    private static SessionManagerInterface $instance;

    /**
     * Session manager mode.
     * 
     * @var Model session_manager
     */
    private Model $manager;

    /**
     * Construct session manager class.
     * 
     * @param HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->setUp($handler);
        
        static::$instance = $this;
    }

    public function manager(): Model
    {
        return $this->manager;
    }

    public function value(): string|int
    {
        return $this->manager()->data->last();
    }

    public function set(string|int $key, string|int|null|array $value): bool
    {
        $this->manager->data[$key] = $value;

        return $this->manager->save();
    }

    public function get(string|int $key): string|int|null|array
    {
        return $this->manager->data->get($key);
    }

    public function remove(string|int $key): bool
    {
        unset($this->manager->data[$key]);

        return $this->manager->save();
    } 

    public static function getInstance(HandlerInterface $handler): SessionManagerInterface
    {
        return isset(static::$instance) ? static::$instance : new static($handler);
    }

    /**
     * Setup session manager.
     * 
     * @return void
     */
    protected function setUp(HandlerInterface $handler): void
    {
        $this->manager = Model::firstOrCreate([
            'session_id' => $handler->request()->sessionID(),
            'msisdn' => $handler->request()->msisdn()
        ]);
    }
}