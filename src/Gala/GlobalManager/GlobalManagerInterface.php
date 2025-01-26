<?php

declare(strict_types=1);

namespace Gala\GlobalManager;

interface GlobalManagerInterface
{
    public static function set(string $key, mixed $value): void;

    public static function get(string $key): mixed;
}
