<?php

namespace app\src;


use ReflectionClass;

class Router
{
    /** @var Route[] $routes */
    private array $routes = [];

    public function register(Route $route)
    {
        $this->routes[] = $route;
    }

    public function resolve()
    {
        $path = Request::getPath();

        foreach ($this->routes as $route) {
            if ($route->path === $path) {
                $controller = new $route->controller;

                echo $controller->{$route->method}();
            }
        }
    }
}