<?php

declare(strict_types=1);

namespace Gala\Base;

use Gala\Base\Exception\BaseInvalidArgumentException;
use Gala\LiquidOrm\DataRepository\DataRepository;
use Gala\LiquidOrm\DataRepository\DataRepositoryFactory;

class BaseModel
{
    private string $tableSchema;
    private string $tableSchemaID;
    private object $repository;

    public function __construct(string $tableSchema, string $tableSchemaID)
    {
        if (empty($this->tableSchema) || empty($this->tableSchemaID)) {
            throw new BaseInvalidArgumentException('These arguments are required.');
        }
        $factory = new DataRepositoryFactory('', $tableSchema, $tableSchemaID);
        $this->repository = $factory->create(DataRepository::class);
    }

    public function getRepo()
    {
        return $this->repository;
    }
}
