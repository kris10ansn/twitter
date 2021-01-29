<?php


namespace app\models;

use app\src\Database;

class UserModel
{
    public int $id;
    public string $username;
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $created_at;
    public string $password;

    public static function from(int $id): ?UserModel
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT * FROM user WHERE id=:id");
        $statement->execute([":id" => $id]);

        return $statement->fetchObject(UserModel::class);
    }

    public static function find($where): ?UserModel
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
        $fetchedObject = $statement->fetchObject(UserModel::class);

        if ($fetchedObject) {
            return $fetchedObject;
        }

        return null;
    }
}