<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\DataRepository;

use Gala\LiquidOrm\DataRepository\Exception\DataRepositoryInvalidArgumentException;
use Gala\LiquidOrm\EntityManager\EntityManagerInterface;
use Throwable;

class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $em;

    /**
     * Main constructor lass
     *
     * @param EntityManagerInterface $em
     * @return void
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function isArray(array $conditions): void
    {
        if (!is_array($conditions)) {
            throw new DataRepositoryInvalidArgumentException('The argument supplied is not an array');
        }
    }

    private function isEmpty(int $id): void
    {
        if (empty($id)) {
            throw new DataRepositoryInvalidArgumentException('Argument should not be empty');
        }
    }

    public function find(int $id): array
    {
        $this->isEmpty($id);
        try {
            return $this->findOneBy(['id' => $id]);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findAll(): array
    {
        try {
            return $this->em->getCrud()->read();
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findBy(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = []
    ): array {
        try {
            return $this->em->getCrud()->read($selectors, $conditions, $parameters, $optional);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findOneBy(array $conditions): array
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->read([], $conditions);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findObjecrtBy(array $conditions = [], array $selectors = []): object
    {
        return $this;
    }

    public function findBySearch(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = []
    ): array {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->search($selectors, $conditions, $parameters, $optional);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findByIdAndDelete(array $conditions): bool
    {
        $this->isArray($conditions);
        try {
            $result = $this->findOneBy($conditions);
            if ($result != null && count($result) > 0) {
                $delete = $this->em->getCrud()->delete($conditions);
                if ($delete) {
                    return true;
                }
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findByIdAndUpdate(array $fields = [], ?int $id = null): bool
    {
        $this->isArray($fields);
        try {
            $result = $this->findOneBy([$this->em->getCrud()->getSchemaID() => $id]);
            if ($result != null && count($result) > 0) {
                $params = (!empty($fields))
                    ? array_merge([$this->em->getCrud()->getSchemaID() => $id], $fields)
                    : $fields;
                $update = $this->em->getCrud()->update($params, $this->em->getCrud()->getSchemaID());
                if ($update) {
                    return true;
                }
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findWithSearchAndPagin(array $args, object $reqest): array
    {
        return [];
    }

    public function findAndReturn(int $id, array $selectors = []): DataRepositoryInterface
    {
        return $this;
    }
}
