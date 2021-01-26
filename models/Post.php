<?php


namespace app\models;


use app\src\Database;

class Post
{
    public int $id;
    public string $text;
    public string $created_at;
    public string $username;
    public string $firstname;
    public string $lastname;
    public int $user_id;

    /** @return Post[] */
    public static function all(): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.id, post.text, post.created_at,
                   user.id as user_id,user.username,
                   user.firstname, user.lastname
            FROM post
            JOIN user
            ON post.user_id=user.id
            ORDER BY post.created_at DESC
        ");

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, Post::class);
    }
}