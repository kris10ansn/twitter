<?php


namespace app\models;


use app\src\Database;
use app\src\Session;

class Post
{
    public int $id;
    public string $text;
    public string $created_at;
    public string $username;
    public string $firstname;
    public string $lastname;
    public int $user_id;
    public int $liked;

    /** @return Post[] */
    public static function all(): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.id, post.text, post.created_at,
                   user.id as user_id,user.username,
                   user.firstname, user.lastname,
                   (
                        SELECT count(*)
                        FROM `like`
                        WHERE `like`.post_id=post.id AND `like`.user_id=:user_id
                   ) as liked
            FROM post
            JOIN user
            ON post.user_id=user.id
            ORDER BY post.created_at DESC
        ");

        $user = Session::getUser();
        $statement->execute(["user_id" => $user->id]);

        return $statement->fetchAll(\PDO::FETCH_CLASS, Post::class);
    }

    public static function like(int $userId, int $postId)
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("INSERT INTO `like` (post_id, user_id) VALUES (:post_id, :user_id)");

        $statement->execute([ "post_id" => $postId, "user_id" => $userId ]);
    }

    public static function userHasLiked(int $userId, int $postId)
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT count(*) FROM `like` WHERE post_id=:post_id AND user_id=:user_id");

        $statement->execute(["post_id" => $postId, "user_id" => $userId]);
    }
}