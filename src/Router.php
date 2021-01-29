<?php

namespace app\src;


use ReflectionClass;

class Router
{
    public const PREVIOUS_URL = "prev_url";

    /** @var Route[] $routes */
    private array $routes = [];

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function resolve()
    {
        $path = Request::getPath();
        $found = false;

        foreach ($this->routes as $route) {
            if ($route->path === $path || preg_match($route->path, $path)) {
                $controller = new $route->controller;

                echo $controller->{$route->method}();
                $found = true;
            }
        }

        if (!$found) {
            echo "404 Not found";
        }

        Session::set(self::PREVIOUS_URL, $path);
    }
}