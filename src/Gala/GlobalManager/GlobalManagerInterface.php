<?php

declare(strict_types=1);

namespace Gala\GlobalManager;

interface GlobalManagerInterface
{
    public function set(string $key, mixed $value): void;

    public function get(string $key): mixed;
}
