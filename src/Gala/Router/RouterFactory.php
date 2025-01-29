<?php

declare(strict_types=1);

namespace Gala\Router;

class RouterFactory
{
    protected RouterInterface $router;

    protected string $dispatchedUrl;

    protected array $routes;
}
