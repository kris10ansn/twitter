<?php


namespace app\models;

use app\src\Database;

class User
{
    public static function find($where)
    {
        $tableName = "user";
        $selectors = implode("AND", array_map(fn($key) => "$key = :$key", array_keys($where)));
        $sql = "SELECT * FROM $tableName WHERE $selectors";

        $db = Database::getInstance();
        $statement = $db->pdo->prepare($sql);

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject();
    }
}