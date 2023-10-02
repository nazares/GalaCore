<?php

declare(strict_types=1);

namespace Gala\DatabaseConnection;

use Gala\DatabaseConnection\Exception\DatabaseConnectionException;
use PDO;
use PDOException;

class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * @var array
     */
    protected array $credetials;

    /**
     * Main constructor class
     *
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credetials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function open(): PDO
    {
        try {
            $params = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->dbh = new PDO(
                $this->credetials['dsn'],
                $this->credetials['username'],
                $this->credetials['password'],
                $params
            );
        } catch (PDOException $exception) {
            throw new DatabaseConnectionException($exception->getMessage(), (int)$exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        $this->dbh = null;
    }
}
