<?php

namespace Bluteki\Ussd\Interfaces\Gateway;

use Bluteki\Ussd\Models\SessionManager;

interface SessionManagerInterface
{
    /**
     * Get session manger model.
     * 
     * @return SessionManager
     */
    public function manager(): SessionManager;

    /**
     * Get current input value.
     * 
     * @return string|int
     */
    public function value(): string|int;

    /**
     * Set item in data.
     * 
     * @param string|int $key
     * @param string|int|null|array $value
     * @return void
     */
    public function set(string|int $key, string|int|null|array $value): bool;

    /**
     * Get item in data.
     * 
     * @param string|int $key
     * @return string|int|null|array $value
     */
    public function get(string|int $key): string|int|null|array;

    /**
     * Remove item in data.
     * 
     * @param string|int $key
     * @return bool
     */
    public function remove(string|int $key);

    /**
     * Get or Create session manager instance.
     * 
     * @param HandlerInterface $request
     * @return SessionManagerInterface
     */
    public static function getInstance(HandlerInterface $request): SessionManagerInterface;
}