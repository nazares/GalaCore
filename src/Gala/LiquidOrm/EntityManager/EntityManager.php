<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\EntityManager;

use Gala\LiquidOrm\EntityManager\CrudInterface;

class EntityManager implements EntityManagerInterface
{
    /** @var CrudInterface */
    protected CrudInterface $crud;

    /**
     * Main constructor class
     *
     * @return void
     */
    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }

    /** @inheritDoc */
    public function getCrud(): object
    {
        return $this->crud;
    }
}
