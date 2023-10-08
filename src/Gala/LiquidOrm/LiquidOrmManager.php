<?php

declare(strict_types=1);

namespace Gala\LiquidOrm;

use Gala\DatabaseConnection\DatabaseConnection;
use Gala\LiquidOrm\DataMapper\DataMapperEnvironmentConfigurarion;
use Gala\LiquidOrm\DataMapper\DataMapperFactory;
use Gala\LiquidOrm\EntityManager\EntityManagerFactory;
use Gala\LiquidOrm\QueryBuilder\QueryBuilder;
use Gala\LiquidOrm\QueryBuilder\QueryBuilderFactory;

class LiquidOrmManager
{
    protected string $tableSchema;

    protected string $tableSchemaID;

    protected array $options;

    protected DataMapperEnvironmentConfigurarion $environmentConfiguration;

    public function __construct(
        DataMapperEnvironmentConfigurarion $environmentConfiguration,
        string $tableSchema,
        string $tableSchemaID,
        ?array $options = []
    ) {
        $this->environmentConfiguration = $environmentConfiguration;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->options = $options;
    }

    public function initialize()
    {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnvironmentConfigurarion::class);
        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchemaID, $this->options);
            }
        }
    }
}
