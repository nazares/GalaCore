<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\DataRepository;

use Gala\LiquidOrm\DataRepository\Exception\DataRepositoryException;

class DataRepositoryFactory
{
    public function construct(
        protected string $crudIdentifier,
        protected string $tableSchema,
        protected string $tableSchemaID
    ) {
        # code...
    }

    public function create(string $dataRepositoryString)
    {
        $dataRepositoryObject = new $dataRepositoryString();
        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new DataRepositoryException($dataRepositoryString . ' is not a valid repository object');
        }
        return $dataRepositoryObject;
    }
}
