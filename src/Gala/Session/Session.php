<?php

declare(strict_types=1);

namespace Gala\Session;

use Gala\Session\Exception\SessionInvalidArgumentException;
use Gala\Session\Storage\SessionStorageInterface;
use Gala\Session\Exception\SessionException;
use Throwable;

class Session implements SessionInterface
{
    protected SessionStorageInterface $storage;

    protected string $sessionName;

    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    public function __construct(string $sessionName, SessionStorageInterface $storage = null)
    {
        if ($this->isSessionKeyValid($sessionName) === false) {
            throw new SessionInvalidArgumentException("{$sessionName} is not a valid session name.");
        }

        $this->sessionName = $sessionName;
        $this->storage = $storage;
    }

    /** @inheritDoc */
    public function set(string $key, mixed $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setSession($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException(
                "An Exception was thrown in retrieving the key from the session storage. {$throwable}"
            );
        }
    }

    /** @inheritDoc */
    public function setArray(string $key, mixed $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setArraySession($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException(
                "An Exception was thrown in retrieving the key from the session storage. {$throwable}"
            );
        }
    }

    /** @inheritDoc */
    public function get(string $key, $default = null): mixed
    {
        try {
            return $this->storage->getSession($key, $default);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /** @inheritDoc */
    public function delete(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->deleteSession($key);
            return true;
        } catch (Throwable $throwable) {
            throw new SessionException();
        }
    }

    /** @inheritDoc */
    public function invalidate(): void
    {
        $this->storage->invalidate();
    }

    /** @inheritDoc */
    public function flush(string $key, $value = null)
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->flush($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException();
        }
    }

    /** @inheritDoc */
    public function has(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        return $this->storage->hasSession($key);
    }

    /**
     * Checks whther the session key is valid according the defined regular expression
     *
     * @param string $key
     * @return boolean
     */
    protected function isSessionKeyValid(string $key): bool
    {
        return (preg_match(self::SESSION_PATTERN, $key) === 1);
    }

    /**
     * Checks whether it has a session key
     *
     * @param string $key
     * @return void
     * @throws SessionInvalidArgumentException
     */
    protected function ensureSessionKeyIsValid(string $key): void
    {
        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgumentException("{$key} is not a valid session key");
        }
    }
}
