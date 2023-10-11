<?php

declare(strict_types=1);

namespace Gala\Base\GlobalManager;

use Gala\GlobalManager\Exception\GlobalManagerException;
use Throwable;

class GlobalManager implements GlobalManagerInterface
{
    /** @inheritDoc */
    public static function set(string $key, $value): void
    {
        $GLOBALS[$key] = $value;
    }

    /** @inheritDoc */
    public static function get(string $key)
    {
        self::isGlobalValid($key);
        try {
            return $GLOBALS[$key];
        } catch (Throwable $throwable) {
            throw new GlobalManagerException('An exception was thrown trying to retrieve the data.');
        }
    }

    /**
     * Check if it has a valid key and its not empty else throw an exception
     *
     * @param string $key
     * @return void
     * @throws GlobalManagerInvalidArgumentException
     */
    private static function isGlobalValid(string $key): void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException('Invalid global key. Please ensure you have set the global value of ' . $key);
        }
        if (empty($key)) {
            throw new GlobalManagerInvalidArgumentException('Argument cannot be empty.');
        }
    }
}
