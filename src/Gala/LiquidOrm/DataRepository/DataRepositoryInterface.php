<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\DataRepository;

interface DataRepositoryInterface
{
    public function find(int $id): array;

    public function findAll(): array;

    public function findBy(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = []
    ): array;

    public function findOneBy(array $conditions): array;

    public function findObjecrtBy(array $conditions = [], array $selectors = []): object;

    public function findBySearch(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = []
    ): array;

    public function findByIdAndDelete(array $conditions): bool;

    public function findByIdAndUpdate(array $conditions = [], int $id = null): bool;

    public function findWithSearchAndPagin(array $args, object $reqest): array;

    public function findAndReturn(int $id, array $selectors = []): self;
}
