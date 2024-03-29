<?php

declare(strict_types=1);

namespace Gala\Router;

use Gala\Router\Exception\RouterBadMethodCallException;
use Gala\Router\RouterInterface;
use Gala\Router\Exception\RouterException;

class Router implements RouterInterface
{
    /**
     * returns an array of route from routing table
     *
     * @var array
     */
    protected array $routes = [];

    /**
     * returns an array of route parameters
     * @var array
     */
    protected array $params = [];

    /**
     * Adds a suffix onto the controller name
     *
     * @var string
     */
    protected string $controllerSuffix = 'controller';

    /**
     * @inheritDoc
     */
    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(string $url): void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformUpperCamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString($this->params);
                $action = $this->params['action'];
                $action = $this->transformCamelCase($action);

                if (\is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new RouterBadMethodCallException();
                }
            } else {
                throw new RouterException();
            }
        } else {
            throw new RouterException();
        }
    }

    public function transformCamelCase(string $string): string
    {
        return \lcfirst($this->transformUpperCamelCase($string));
    }

    public function transformUpperCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Match the route to the routes in the routing table, setting the $this->params property
     * if a route is found.
     *
     * @param string $url
     * @return bool
     */
    private function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Get the namespace for the controller class. The namespcae defined within the route parameters
     * only if it was added.
     *
     * @param string $string
     * @return string
     */
    public function getNamespace(string $string): string //TODO:
    {
        $namespace = 'App\Controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}
