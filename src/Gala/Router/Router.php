<?php

declare(strict_types=1);

namespace Gala\Router;

use Exception;
use Gala\Router\Exception\RouterBadMethodCallException;
use Gala\Router\Exception\RouterException;

class Router implements RouterInterface
{
    /**
     * returns an array of route from our routing table
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
     * @var string
     */
    protected string $controllerSuffix = 'controller';

    /**
     * @inheritDoc
     */
    public function add(string $route, array $params = []): void
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(string $url): void
    {
        if (!$this->match($url)) {
            throw new Exception('404 not found');
        }

        $controllerString = $this->params['controller'];
        $controllerString = $this->transformUpperCamelCase($controllerString . $this->controllerSuffix);
        $controllerString = $this->getNamespace($controllerString) . $controllerString;

        $path = str_replace('\\', '/', $controllerString) . '.php';

        if (file_exists($path)) {
            require_once $path;
        }

        if (!class_exists($controllerString)) {
            throw new Exception("controller class $controllerString does not exist");
        }
        $controllerObject = new $controllerString($this->params);
        var_dump($controllerObject);
        $action = $this->params['action'];
        $action = $this->transformCamelCase($action);
        if (!is_callable([$controllerObject, $action])) {
            throw new Exception('invalid method ' . $action);
        }
        $controllerObject->$action();
        // $str = 'Home-controller';

        // $cont = $this->transformUpperCamelCase($str);

        // var_dump($cont);

        //$controllerString = $this->params[]

        // $controller = new \App\Controller\HomeController([]);

        // $controller->indexActon();



        // $url = $this->formatQueryString($url);
        // if ($this->match($url)) {
        //     $controllerString = $this->params['controller'] . $this->controllerSuffix;
        //     $controllerString = $this->transformUpperCamelCase($controllerString);
        //     $controllerString = $this->getNamespace($controllerString) . $controllerString;

        //     if (class_exists($controllerString)) {
        //         $controllerObject = new $controllerString($this->params);
        //         $action = $this->params['action'] . 'Action';
        //         $action = $this->transformCamelCase($action);
        //         var_dump($action);
        //         if (!\is_callable([$controllerObject, $action])) {
        //             $controllerObject->$action();
        //         } else {
        //             throw new RouterBadMethodCallException('Invalid method');
        //         }
        //     } else {
        //         throw new RouterException('Controller class does not exist');
        //     }
        // } else {
        //     throw new RouterException('404 ERROR no page found');
        // }
    }

    public function transformUpperCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public function transformCamelCase(string $string): string
    {
        return \lcfirst($this->transformUpperCamelCase($string));
    }

    /**
     * Match the route to the routes in the routing table, setting the $this->params property
     * if a route is found
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
     * Get the namespace for the controller class. the namespace difined within the route parameters
     * only if it was added.
     *
     * @param string $string
     * @return string
     */
    public function getNamespace(string $string): string
    {
        $namespace = 'App\Controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

    /**
     */
    protected function formatQueryString($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return rtrim($url, '/');
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
