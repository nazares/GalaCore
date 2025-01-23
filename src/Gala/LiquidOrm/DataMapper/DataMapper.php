<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\DataMapper;

use Gala\DatabaseConnection\DatabaseConnectionInterface;
use Gala\LiquidOrm\DataMapper\Exception\DataMapperException;
use PDO;
use PDOStatement;
use Throwable;

class DataMapper implements DataMapperInterface
{
    /** @var DatabaseConnectionInterface */
    private DatabaseConnectionInterface $dbh;

    /** @var PDOStatement */
    private PDOStatement $statement;

    /**
     * Main constructor class
     * @return void
     */
    public function __construct(DatabaseConnectionInterface $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * Checks the incoming $value isn't empty else thow an exception
     *
     * @param mixed $value
     * @param string|null $errorMessage
     * @return void
     * @throws DataMapperException
     */
    private function isEmpty(mixed $value, string $errorMessage = null)
    {
        if (empty($value)) {
            throw new DataMapperException($errorMessage);
        }
    }

    /**
     * Checks the incoming argument $value is an array else throw an exception
     *
     * @param array $value
     * @return void
     * @throws DataMapperException
     */
    private function isArray(array $value)
    {
        if (!is_array($value)) {
            throw new DataMapperException('The argument needs to be an array');
        }
    }

    /** @inheritDoc */
    public function prepare(string $sqlQuery): DataMapperInterface
    {
        $this->statement = $this->dbh->open()->prepare($sqlQuery);
        return $this;
    }

    /** @inheritDoc */
    public function bind(mixed $value): mixed
    {
        try {
            switch ($value) {
                case is_bool($value):
                case intval($value):
                    $dataType = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $dataType = PDO::PARAM_NULL;
                    break;
                default:
                    $dataType = PDO::PARAM_STR;
                    break;
            }
            return $dataType;
        } catch (DataMapperException $exception) {
            throw $exception;
        }
    }

    /** @inheritDoc */
    public function bindParameters(array $fields, bool $isSearch = false): self
    {
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
            if ($type) {
                return $this;
            }
        }
        return false;
    }

    /**
     * UnBinds a value to a corresponding name or question mark placeholder in the SQL
     * statement that was used to prepare the statement
     *
     * @param array $fields
     * @return PDOStatement
     * @throws DataMapperException
     */
    protected function bindValues(array $fields): PDOStatement
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, $value, $this->bind($value));
        }
        return $this->statement;
    }

    protected function bindSearchValues(array $fields)
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, '%' . $value . "%", $this->bind($value));
        }
        return $this->statement;
    }

    /** @inheritDoc */
    public function execute(): void
    {
        if ($this->statement) {
            return $this->statement->execute();
        }
    }

    /** @inheritDoc */
    public function numRows(): int
    {
        if ($this->statement) {
            return $this->statement->rowCount();
        }
    }

    /** @inheritDoc */
    public function result(): object
    {
        if ($this->statement) {
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }
    }

    /** @inheritDoc */
    public function results(): array
    {
        if ($this->statement) {
            return $this->statement->fetchAll();
        }
    }

    /** @inheritDoc */
    public function getLastId(): int
    {
        try {
            if ($this->dbh->open()) {
                $lastID = $this->dbh->open()->lastInsertId();
                if (!empty($lastID)) {
                    return intval($lastID);
                }
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
}
