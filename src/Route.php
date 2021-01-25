<?php


namespace app\src;


class Route
{
    public string $path;
    public string $method;
    public string $controller;

    public function __construct(string $path, $controller, string $method)
    {
        $this->path = $path;
        $this->method = $method;
        $this->controller = $controller;
    }


}