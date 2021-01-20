<?php


namespace app\src;


class Request
{
    public static function getPath(): string
    {
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $argumentsPosition = strpos($path, "?");

        if ($argumentsPosition === false) {
            return $path;
        }

        return substr($path, 0, $argumentsPosition);
    }

    public static function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public static function getBody(): array
    {
        $body = [];
        $method = self::getMethod();

        $inputType = $method === "get"? INPUT_GET : INPUT_POST;
        $requestObject = $method === "get"? $_GET : $_POST;

        foreach ($requestObject as $key => $value) {
            $body[$key] = filter_input($inputType, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }
}

