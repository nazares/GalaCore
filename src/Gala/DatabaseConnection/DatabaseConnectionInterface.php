<?php

declare(strict_types=1);

namespace Gala\DatabaseConnection;

use PDO;

interface DatabaseConnectionInterface
{
    /**
     * Create a new database connection
     *
     * @return PDO
     */
    public function open(): PDO;

    /**
     * Close database connection
     *
     * @return void
     */
    public function close(): void;
}
