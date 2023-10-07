<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\QueryBuilder;

use Gala\LiquidOrm\QueryBuilder\QueryBuilderInterface;

class QueryBuilderFactory
{
    /**
     * Main constructor class
     *
     * @return void
     */
    public function __construct()
    {
        //TODO:
    }

    /**
     *
     */
    public function create(string $queryBuilderString): QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();
        if (!$queryBuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderException($queryBuilderString . ' is not a valid Query builder object.');
        }
        return new QueryBuilder();
    }
}
