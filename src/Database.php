<?php


namespace app\src;


use PDO;

/**
 * Class Database
 * @package app\src
 */
final class Database
{
    private static ?Database $instance = null;
    public PDO $pdo;

    private function __construct() {
        $host = "localhost";
        $port = 3306;
        $database = "twitter";
        $username = "root";
        $password = "ncWMI1w5yzdpD1KV";
        $charset = "utf8";

        $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=$charset", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
}