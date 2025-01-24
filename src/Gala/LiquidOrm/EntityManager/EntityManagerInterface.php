<?php

declare(strict_types=1);

namespace Gala\LiquidOrm\EntityManager;

interface EntityManagerInterface
{
    public function getCrud(): object;
}
