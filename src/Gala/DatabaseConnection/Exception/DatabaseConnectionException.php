<?php

declare(strict_types=1);

namespace Gala\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionException extends PDOException
{
    protected $message;

    protected $code;

    /**
     * Main constructor class which overrides the parent constructor and set the message
     * and the code properties which is optional
     *
     * @param string $message
     * @param int $code
     * @return void
     */
    public function __constructor($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
