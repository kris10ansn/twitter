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
    public ?string  $biography;

    public function follow(int $followId): bool
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("INSERT INTO follow (follower_id, followed_id) VALUES (:id, :follow_id)");

        $statement->bindValue(":id", $this->id);
        $statement->bindValue(":follow_id", $followId);

        return $statement->execute();
    }

    public function unfollow(int $followedId): bool
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("DELETE FROM follow WHERE follower_id=:id AND followed_id=:followed_id");

        $statement->bindValue(":id", $this->id);
        $statement->bindValue(":followed_id", $followedId);

        return $statement->execute();
    }

    public function follows(int $userId): bool
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT * FROM follow WHERE follower_id=:id AND followed_id=:user_id");

        $statement->bindValue(":id", $this->id);
        $statement->bindValue(":user_id", $userId);

        $statement->execute();

        if ($statement->fetch(\PDO::FETCH_ASSOC)) {
            return true;
        }

        return false;
    }

    public function followerCount(): int
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT COUNT(*) FROM follow WHERE followed_id=:user_id");
        $statement->execute([":user_id" => $this->id]);

        return (int) $statement->fetchColumn();
    }

    public function followsCount(): int
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT COUNT(*) FROM follow WHERE follower_id=:user_id");
        $statement->execute([":user_id" => $this->id]);

        return (int) $statement->fetchColumn();
    }

    public static function from(int $id): ?UserModel
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT * FROM user WHERE id=:id");
        $statement->execute([":id" => $id]);

        $fetchedObject = $statement->fetchObject(UserModel::class);

        if ($fetchedObject) {
            return $fetchedObject;
        }

        return null;
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