<?php

namespace Gala\Base;

use Gala\LiquidOrm\DataRepository\DataRepositoryFactory;
use Gala\Base\Exception\BaseInvalidArgumentException;
use Gala\LiquidOrm\DataRepository\DataRepository;

class BaseModel
{
    private string $tableSchema;

    private string $tableSchemaID;

    private DataRepository $repository;

    public function __construct(string $tableSchema, string $tableSchemaID)
    {
        if (empty($tableSchema) || empty($tableSchemaID)) {
            throw new BaseInvalidArgumentException('These arguments are required.');
        }
        $factory = new DataRepositoryFactory('', $tableSchema, $tableSchemaID);
        $this->repository = $factory->create(DataRepository::class);
    }

    public function getRepository(): DataRepository
    {
        return $this->repository;
    }
}
