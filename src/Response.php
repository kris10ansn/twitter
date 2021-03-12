<?php


namespace app\src;


/**
 * Class Response
 * @package app\src
 */
class Response
{
    /**
     * @param int $code
     */
    public static function statusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * @param $path
     */
    public static function redirect($path)
    {
        header("Location: " . constant("APP_URL_ROOT") . "$path");
    }

    /**
     * @return string
     */
    public static function back(): string
    {
        return "<script>window.history.back()</script>";
    }

    /**
     * @return string
     */
    public static function removeGetParameters(): string
    {
        $url = Request::getPath();
        $urlRoot = APP_URL_ROOT;
        return "<script>window.history.pushState({}, 'Remove get parameters', '{$urlRoot}{$url}')</script>";
    }
}