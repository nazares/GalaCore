<?php

declare(strict_types=1);

namespace Gala\Session;

use Gala\Session\Exception\SessionInvalidArgumentException;

interface SessionInterface
{
    /**
     * Sets a specific value to a specific key of the session
     *
     * @param string $key The key of the item to store.
     * @param mixed $value The value of the item to store. Must be serializable
     * @return void
     * @throws SessionInvalidArgumentExeption MUST be thrown if the $key string is not a legal value.
     */
    public function set(string $key, mixed $value): void;

    /**
     * Sets the specific value to a specific array key of the session
     *
     * @param string $key The key of the item to store.
     * @param mixed $value The value of the item to store. Must be serializable.
     * @return void
     * @throws SessionInvalidArgumentException MUST be thrown if the $key string is not a legal value.
     */
    public function setArray(string $key, mixed $value): void;

    /**
     * Gets/returns the value of a specific key of the session
     *
     * @param string $key The key of the item to store.
     * @param mixed $default The default value to return if the request value can't be found.
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Removes the value for the specified key from the session.
     *
     * @param string $key The key of the item that will be unset.
     * @return bool
     * @throws SessionInvalidArgumentException
     */
    public function delete(string $key): bool;

    /**
     * Destroy the session. Along with session cookies
     *
     * @since 1.0.0
     * @return void
     */
    public function invalidate(): void;

    /**
     * Returns the requested value and remove if from the session
     *
     * @since 1.0.0
     * @param string $key The key to retrieve and remove the value for.
     * @param mixed $value The default value to return if the requested value cannot be found.
     * @return void
     */
    public function flush(string $key, mixed $value = null);

    /**
     * Determines whether an item is present in the session.
     *
     * @param string $key The session key.
     * @return bool
     * @throws SessionInvalidArgumentException MUST be thrown if the $key string is not a legal value.
     */
    public function has(string $key): bool;
}
