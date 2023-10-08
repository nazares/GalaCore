<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\EntityManager;

use Gala\LiquidOrm\DataMapper\DataMapper;
use Gala\LiquidOrm\EntityManager\Exception\CrudException;
use Gala\LiquidOrm\EntityManager\EntityManagerInterface;
use Gala\LiquidOrm\QueryBuilder\QueryBuilderInterface;
use Gala\LiquidOrm\DataMapper\DataMapperInterface;

class EntityManagerFactory
{
    protected DataMapperInterface $dataMapper;

    protected QueryBuilderInterface $queryBuilder;

    /**
     * Main constructor class
     *
     * @param DataMapperInterface $dataMapper
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Factory method create
     *
     * @param string $crudString
     * @param string $tableSchema
     * @param string $tableSchemaID
     * @param array $options
     * @return EntityManagerInterface
     * @throws CrudException
     */
    public function create(
        string $crudString,
        string $tableSchema,
        string $tableSchemaID,
        array $options = []
    ): EntityManagerInterface {
        $crudObject = new $crudString($this->dataMapper, $this->queryBuilder, $tableSchema, $tableSchemaID, $options);
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudException($crudString . ' is not a valid crud object');
        }
        return new EntityManager($crudObject);
    }
}
