<?php


namespace app\src;


class Response
{
    public static function statusCode(int $code)
    {
        http_response_code($code);
    }

    public static function redirect($path)
    {
        header("Location: " . constant("APP_URL_ROOT") . "$path");
    }
}