<?php

declare(strict_types=1);

namespace Gala\Session;

interface SessionInterface
{
    public function set(string $key, mixed $value): void;

    public function setArray(string $key, mixed $value): void;

    public function get(string $key, $default = null);

    public function delete(string $key): bool;

    public function invalidate(): void;

    public function flush(string $key, mixed $value);

    public function has(string $key): bool;
}
