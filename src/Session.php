<?php


namespace app\src;


use app\models\User;

class Session
{
    private static ?User $user = null;

    public static function start()
    {
        session_start();
    }

    public static function getUser(): ?User
    {
        if (self::$user === null) {
            $userId = Session::get("user");

            if ($userId !== null) {
                self::$user = User::find(["id" => $userId]);
            }
        }

        return self::$user;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }
}