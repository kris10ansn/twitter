<?php


namespace app\src;


/**
 * Class Route
 * @package app\src
 */
class Route
{
    public string $path;
    public string $method;
    public string $controller;

    /**
     * Route constructor.
     * @param string $path
     * @param $controller
     * @param string $method
     * @param false $new
     */
    public function __construct(string $path, $controller, string $method, $new=false)
    {
        $path = preg_replace(
            ["/\//", "/:(\w+)/"],
            ["\/",   "(?<$1>\w+)"],
            $path
        );
        $path = "/^{$path}(?:\/$|$)/";

        $this->path = $path;
        $this->method = $method;
        $this->controller = $controller;
    }


}