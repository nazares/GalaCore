<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\DataMapper;

use Gala\DatabaseConnection\DatabaseConnectionInterface;
use Gala\LiquidOrm\DataMapper\Exception\DataMapperException;

class DataMapperFactory
{
    /**
     * Main constructor class
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration): DataMapperInterface
    {
        $credentials = (new $dataMapperEnvironmentConfiguration([]))->getDatabaseCredentials('mysql');
        $databaseConnectionObject = new $databaseConnectionString($credentials);
        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException($databaseConnectionString . ' is not a valid databade connection object');
        }
        return new DataMapper($databaseConnectionObject);
    }
}
