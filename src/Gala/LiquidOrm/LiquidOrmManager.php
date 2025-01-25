<?php

declare(strict_types=1);

namespace Gala\LiquidOrm;

use Gala\DatabaseConnection\DatabaseConnection;
use Gala\LiquidOrm\DataMapper\DataMapperEnvironmentConfiguration;
use Gala\LiquidOrm\DataMapper\DataMapperFactory;
use Gala\LiquidOrm\EntityManager\Crud;
use Gala\LiquidOrm\EntityManager\EntityManagerFactory;
use Gala\LiquidOrm\QueryBuilder\QueryBuilder;
use Gala\LiquidOrm\QueryBuilder\QueryBuilderFactory;

class LiquidOrmManager
{
    //

    public function __construct(
        protected DataMapperEnvironmentConfiguration $environmentConfiguration,
        protected string $tableSchema,
        protected string $tableSchemaID,
        protected ?array $options
    ) {
        # code ...
    }

    public function initialize()
    {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnvironmentConfiguration::class);
        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(
                    Crud::class,
                    $this->tableSchema,
                    $this->tableSchemaID,
                    $this->options
                );
            }
        }
    }
}
