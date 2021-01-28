<?php


namespace app\models;


use app\src\Database;
use PDO;

class Trending
{
    public static function getTop(int $n): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare(
            "SELECT name, COUNT(name) as posts FROM hashtagged GROUP BY name ORDER BY posts DESC LIMIT 0, $n"
        );

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}