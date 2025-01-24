<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\QueryBuilder;

use Gala\LiquidOrm\QueryBuilder\Exception\QueryBuilderException;

class QueryBuilderFactory
{
    /**
     * Main constructor method
     *
     * @return void
     */
    public function __construct()
    {
        #
    }

    public function create(string $queryBuilderString): QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();
        if (!$queryBuilderString instanceof QueryBuilderInterface) {
            throw new QueryBuilderException($queryBuilderString . 'is not a valid Query builder object');
        }
        return new $queryBuilderObject();
    }
}
