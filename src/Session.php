<?php


namespace app\src;


use app\models\UserModel;

/**
 * Class Session
 * @package app\src
 */
class Session
{
    private const FLASH_KEY = "flash_msg";
    private static ?UserModel $user = null;

    public static function start()
    {
        session_start();

        if (isset($_SESSION[self::FLASH_KEY])) {
            foreach ($_SESSION[self::FLASH_KEY] as $key => &$flashMessage) {
                if ($flashMessage["remove"] === true) {
                    unset($_SESSION[self::FLASH_KEY][$key]);
                } else {
                    $flashMessage["remove"] = true;
                }
            }
        }
    }

    public static function getUser(): ?UserModel
    {
        if (self::$user === null) {
            $userId = Session::get("user");

            if ($userId !== null) {
                self::$user = UserModel::find(["id" => $userId]);
            }
        }

        return self::$user;
    }

    /**
     * @param $key
     * @param $message
     */
    public static function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            "message" => $message,
            "remove" => false
        ];
    }

    /**
     * @param $key
     * @return string|null
     */
    public static function getFlash($key): ?string
    {
        if (isset($_SESSION[self::FLASH_KEY][$key])) {
            return $_SESSION[self::FLASH_KEY][$key]["message"];
        }

        return null;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param $key
     */
    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function logout()
    {
        self::$user = null;
        self::remove("user");
    }
}