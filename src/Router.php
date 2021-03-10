<?php

namespace app\src;


use app\controllers\ErrorController;

/**
 * Class Router
 * @package app\src
 */
class Router
{
    /** @var Route[] $routes */
    private array $routes = [];

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function resolve()
    {
        Request::init();
        $path = Request::getPath();
        $found = false;

        foreach ($this->routes as $route) {
            // Setter alfakrøll foran preg_match for å unngå varsler om $path ikke er regex
            if (@preg_match($route->path, $path, $matches)) {
                $controller = new $route->controller;

                echo $controller->{$route->method}($matches);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $controller = new ErrorController();
            echo $controller->error404();
        }
    }
}