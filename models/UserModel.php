<?php


namespace app\models;

use app\src\Database;

class UserModel
{
    public const SORT_FOLLOWERS = "(SELECT COUNT(*) FROM follow WHERE followed_id=user.id)";

    public int $id;
    public string $username;
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $created_at;
    public string $password;
    public string  $biography;

    private ?int $followerCount = null;
    private ?int $followsCount = null;

    public array $fields = [ "username", "firstname", "lastname", "email", "password", "biography" ];


    public function sync(): bool
    {
        $db = Database::getInstance();
        $fields = implode(",", array_map(fn($f) => "$f=:$f", $this->fields));

        $statement = $db->pdo->prepare("
            UPDATE user
            SET $fields
            WHERE user.id=:id
        ");

        foreach ($this->fields as $fieldName) {
            $statement->bindValue(":$fieldName", $this->{$fieldName});
        }

        $statement->bindValue(":id", $this->id);

        return $statement->execute();
    }

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
        if ($this->followerCount !== null) {
            return $this->followerCount;
        }

        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT COUNT(*) FROM follow WHERE followed_id=:user_id");
        $statement->execute([":user_id" => $this->id]);

        $this->followerCount = (int) $statement->fetchColumn();

        return $this->followerCount;
    }

    public function followers(): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT * FROM follow JOIN user ON follower_id=user.id WHERE followed_id=:id");
        $statement->execute([":id" => $this->id]);

        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public function following(): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT * FROM follow JOIN user ON follow.followed_id=user.id WHERE follower_id=:id");
        $statement->execute([":id" => $this->id]);

        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public function followsCount(): int
    {
        if ($this->followsCount !== null) {
            return $this->followsCount;
        }

        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT COUNT(*) FROM follow WHERE follower_id=:user_id");
        $statement->execute([":user_id" => $this->id]);

        $this->followsCount = (int) $statement->fetchColumn();
        return $this->followsCount;
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

    public static function all($sort="user.created_at", $order="ASC"): array
    {
        $db = Database::getInstance();
        $statement = $db->pdo->prepare("SELECT * FROM user ORDER BY $sort $order");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}