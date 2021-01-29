<?php


namespace app\src;


class Request
{
    // Har kun funksjon for GET og POST foreløpig (kanskje permanent)
    public const METHOD_GET = "get";
    public const METHOD_POST = "post";

    public static function _getPath(): string
    {
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $argumentsPosition = strpos($path, "?");

        if ($argumentsPosition === false) {
            return $path;
        }

        return substr($path, 0, $argumentsPosition);
    }

    public static function getPath()
    {
        return str_replace(constant("APP_URL_ROOT"), "", $_SERVER["REQUEST_URI"]);
    }

    public static function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public static function getBody(): array
    {
        $body = [];
        $method = self::getMethod();

        $inputType = $method === self::METHOD_GET ? INPUT_GET : INPUT_POST;
        $requestObject = $method === self::METHOD_GET ? $_GET : $_POST;

        foreach ($requestObject as $key => $value) {
            $body[$key] = filter_input($inputType, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    public static function getParameter(string $method, string $key)
    {
        $requestObject = $method === self::METHOD_GET ? $_GET : $_POST;
        return $requestObject[$key] ?? null;
    }
}

