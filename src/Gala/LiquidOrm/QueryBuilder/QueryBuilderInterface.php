<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\QueryBuilder;

interface QueryBuilderInterface
{
    public function insertQuery(): string;

    public function selectQuery(): string;

    public function updateQuery(): string;

    public function delereQuery(): string;

    public function rawQuery(): string;
}
