<?php

declare(strict_types=1);

namespace Gala\GlobalManager;

use Gala\GlobalManager\Exception\GlobalManagerException;
use Gala\GlobalManager\Exception\GlobalManagerInvalidArgumentException;
use Throwable;

class GlobalManager implements GlobalManagerInterface
{
    public static function set(string $key, mixed $value): void
    {
        $GLOBALS[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        self::isGlobalValid($key);
        try {
            return $GLOBALS[$key];
        } catch (Throwable $throwable) {
            throw new GlobalManagerException('An exception was thrown trying to retrieve the data.');
        }
    }

    /**
     * Checks if the key is valid and it's not empty else throw an exception
     *
     * @param string $key
     * @return void
     * @throws GlobalManagerInvalidArgumentException
     */
    private static function isGlobalValid(string $key): void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException(
                'Invalid global key. Please ensure you have set the global state for ' . $key
            );
        }
        if (empty($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException('Argument cannot be empty');
        }
    }
}
