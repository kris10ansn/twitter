<?php


namespace app\models;


use app\src\Database;
use app\src\Session;

class Hashtag
{
    public static function all(string $name): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT
                post.*, user.firstname, user.lastname, user.username,
                (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id AND `like`.user_id=:user_id) as liked,
                (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id) as likes
            FROM hashtagged
                JOIN post ON hashtagged.post_id = post.id
                JOIN user ON post.user_id = user.id
            WHERE name=:name
            ORDER BY post.created_at
        ");

        $userId= Session::get("user");

        $statement->bindValue(":name", $name);
        $statement->bindValue(":user_id", $userId);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, PostModel::class);
    }
}