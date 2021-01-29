<?php


namespace app\models;


use app\src\Database;
use app\src\Session;

class PostModel
{
    public int $id;
    public string $text;
    public string $created_at;
    public string $username;
    public string $firstname;
    public string $lastname;
    public int $user_id;
    public int $liked;
    public int $likes;

    public static function from(int $id): PostModel
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.*, user.username, user.firstname, user.lastname
            FROM post JOIN user ON post.user_id = user.id WHERE post.id=:id
        ");

        $statement->execute([":id" => $id]);

        return $statement->fetchObject(PostModel::class);
    }

    /** @return PostModel[] */
    public static function all(): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.*, user.username, user.firstname, user.lastname,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id AND `like`.user_id=:user_id) as liked,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id) as likes
            FROM post JOIN user ON post.user_id = user.id ORDER BY post.created_at DESC
        ");

        $user = Session::getUser();

        $statement->bindValue(":user_id", $user->id ?? null);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, PostModel::class);
    }

    public function like(UserModel $user)
    {
        $db = Database::getInstance();
        $statement = $db->pdo->prepare("INSERT INTO `like` (post_id, user_id) VALUES (:post_id, :user_id)");
        $statement->execute([ "post_id" => $this->id, "user_id" => $user->id ]);
    }

    public function unlike(UserModel $user)
    {
         $db = Database::getInstance();
         $statement = $db->pdo->prepare("DELETE FROM `like` WHERE user_id=:user_id AND post_id=:post_id");
         $statement->execute([ "post_id" => $this->id, "user_id" => $user->id ]);
    }

    public function likedBy(UserModel $user): bool
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT count(*) as liked FROM `like` WHERE post_id=:post_id AND user_id=:user_id");

        $statement->execute(["post_id" => $this->id, "user_id" => $user->id]);
        $obj = $statement->fetchObject();

        return (bool) $obj->liked;
    }
}