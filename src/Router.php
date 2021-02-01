<?php

namespace app\src;


use ReflectionClass;

class Router
{
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
            // Setter alfakrøll foran preg_match for å unngå varsler om $path ikke er regex
            if ($route->path === $path || $route->path . "/" === $path || @preg_match($route->path, $path)) {
                $controller = new $route->controller;

                echo $controller->{$route->method}();
                $found = true;
            }
        }

        if (!$found) {
            echo "404 Not found";
        }
    }
}