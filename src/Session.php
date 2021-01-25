<?php


namespace app\src;


use app\models\User;

class Session
{
    private const FLASH_KEY = "flash_msg";
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

    public static function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            "message" => $message,
            "remove" => false
        ];
    }

    public static function getFlash($key): ?string
    {
        if (isset($_SESSION[self::FLASH_KEY][$key])) {
            return $_SESSION[self::FLASH_KEY][$key]["message"];
        }

        return null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }
}