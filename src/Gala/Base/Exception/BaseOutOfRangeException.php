<?php

declare(strict_types=1);

namespace Gala\Base\Exception;

use OutOfRangeException;

class BaseOutOfRangeException extends OutOfRangeException
{
    /**
     * Exception thrown if a value is not a valid key. This represents errors that cannot be
     * detected at compile time.
     *
     * @param string $message
     * @param integer $code
     * @param OutOfRangeException $previous
     * @throws RuntimeException
     */
    public function __construct(string $message, int $code = 0, OutOfRangeException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
