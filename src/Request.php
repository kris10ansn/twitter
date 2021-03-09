<?php


namespace app\src;


/**
 * Class Request
 * @package app\src
 */
class Request
{
    // Har kun funksjon for GET og POST foreløpig (kanskje permanent)
    public const METHOD_GET = "get";
    public const METHOD_POST = "post";

    public static function init()
    {
        $path = self::getPathRaw();
        $query = parse_url($path, PHP_URL_QUERY);
        parse_str($query, $parsedQuery);

        foreach ($parsedQuery as $key => $value) {
            $_GET[$key] = $value;
        }
    }

    /**
     * @return string|string[]
     */
    public static function getPathRaw() {
        return str_replace(constant("APP_URL_ROOT"), "", $_SERVER["REQUEST_URI"]);
    }

    /**
     * @return false|string|string[]
     */
    public static function getPath()
    {
        $path = self::getPathRaw();
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

    /**
     * @param null $method
     * @return array
     */
    public static function getBody($method = null): array
    {
        $body = [];
        $method = $method ?? self::getMethod();

        $inputType = $method === self::METHOD_GET ? INPUT_GET : INPUT_POST;
        $requestObject = $method === self::METHOD_GET ? $_GET : $_POST;

        foreach ($requestObject as $key => $value) {
            $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    /**
     * @param string $method
     * @param string $key
     * @return mixed|null
     */
    public static function getParameter(string $method, string $key)
    {
        $requestObject = self::getBody($method);
        return $requestObject[$key] ?? null;
    }
}

