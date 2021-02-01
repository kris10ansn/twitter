<?php


namespace app\src;


class Path
{
    public static function getParameter(string $path): ?string
    {
        preg_match("/\/\w+\/(\w+(?:\/$|$))/", $path, $matches);

        return $matches[1] ?? null;
    }
    public static function withParameter($route): string
    {
        return "/\/$route\/\w+(?:\/$|$)/";
    }
}