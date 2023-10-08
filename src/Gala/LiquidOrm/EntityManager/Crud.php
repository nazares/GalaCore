<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\EntityManager;

use Gala\LiquidOrm\DataMapper\DataMapper;
use Gala\LiquidOrm\QueryBuilder\QueryBuilder;
use Throwable;

class Crud implements CrudInterface
{
    /** @var DataMapper*/
    protected DataMapper $dataMapper;

    /** @var QueryBuilder */
    protected QueryBuilder $queryBuilder;

    protected string $tableSchema;

    protected string $tableSchemaID;

    protected array $options;

    /**
     * Main constructor class
     */
    public function __construct(
        DataMapper $dataMapper,
        QueryBuilder $queryBuilder,
        string $tableSchema,
        string $tableSchemaID,
        ?array $options = []
    ) {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->options = $options;
    }

    /** @inheritDoc */
    public function getSchema(): string
    {
        return (string)$this->tableSchema;
    }

    /** @inheritDoc */
    public function getSchemaID(): string
    {
        return (string)$this->tableSchemaID;
    }

    /** @inheritDoc */
    public function lastID(): int
    {
        return $this->dataMapper->getLastId();
    }

    /** @inheritDoc */
    public function create(array $fields = []): bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'insert', 'fields' => $fields];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /** @inheritDoc */
    public function read(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = []
    ): array {
        try {
            $args = [
                'table'      => $this->getSchema(),
                'type'       => 'select',
                'selectors'  => $selectors,
                'conditions' => $conditions,
                'params'     => $parameters,
                'extras'     => $optional
            ];
            $query = $this->queryBuilder->buildQuery($args)->selectQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters));
            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
        } catch (Throwable $throwable) {
            throw $http_response_header;
        }
    }

    /** @inheritDoc */
    public function update(array $fields = [], string $primaryKey = ''): bool
    {
        try {
            $args = [
                'table' => $this->getSchema(),
                'type' => 'update',
                'fields' => $fields,
                'primary_key' => $primaryKey
            ];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /** @inheritDoc */
    public function delete(array $conditions = []): bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'delete', 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /** @inheritDoc */
    public function search(array $selectors = [], array $conditions = []): array
    {
        try {
            $args = [
                'table' => $this->getSchema(),
                'type' => 'search',
                'selectors' => $selectors,
                'conditions' => $conditions
            ];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /** @inheritDoc */
    public function rawQuery(string $rawQuery, ?array $conditions)
    {
        try {
            $args = [
                'table' => $this->getSchema(),
                'type' => 'raw',
                'raw' => $rawQuery,
                'conditions' => $conditions
            ];
            $query = $this->queryBuilder->buildQuery($args)->rawQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows()) {
                // TODO:
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
    //
}
