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

    /**
     * @param UserModel $user
     * @return PostModel[]
     */
    public static function postedBy(UserModel $user): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.*, user.username, user.firstname, user.lastname,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id AND `like`.user_id=:self_user_id) as liked,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id) as likes
            FROM post
                JOIN user ON post.user_id = user.id
            WHERE user.id=:user_id
            ORDER BY post.created_at DESC
        ");

        $selfUserId = Session::get("user");

        $statement->bindValue(":self_user_id", $selfUserId);
        $statement->bindValue(":user_id", $user->id);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, PostModel::class);
    }

    public static function from(int $id): PostModel
    {
        $db = Database::getInstance();

        $user = Session::getUser();

        if ($user !== null) {
            $likedQuery = "(SELECT count(*) FROM `like` WHERE `like`.post_id=post.id AND `like`.user_id=:user_id) as liked";
        } else {
            $likedQuery = "0 as liked";
        }

        $statement = $db->pdo->prepare("
            SELECT post.*, user.username, user.firstname, user.lastname,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id) as likes,
                   $likedQuery
            FROM post JOIN user ON post.user_id = user.id WHERE post.id=:id
        ");

        if ($user !== null) {
            $statement->bindValue(":user_id", $user->id);
        }

        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetchObject(PostModel::class);
    }

    /**
     * @param string $sort
     * @param string $order
     * @return PostModel[]
     */
    public static function all($sort = "post.created_at", $order="DESC"): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.*, user.username, user.firstname, user.lastname,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id AND `like`.user_id=:user_id) as liked,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id) as likes
            FROM post JOIN user ON post.user_id = user.id ORDER BY $sort $order
        ");

        $userId = Session::get("user");

        $statement->bindValue(":user_id", $userId);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, PostModel::class);
    }

    public static function feed(int $userId): array
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("
            SELECT post.*, user.username, user.firstname, user.lastname,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id AND `like`.user_id=:user_id) as liked,
                   (SELECT count(*) FROM `like` WHERE `like`.post_id=post.id) as likes
            FROM post
                JOIN user ON post.user_id = user.id
            WHERE post.user_id
                      IN (SELECT followed_id FROM follow WHERE follower_id=:user_id)
                OR post.user_id=:user_id
            ORDER BY post.created_at DESC
        ");

        $statement->execute([ ":user_id" => $userId ]);

        return $statement->fetchAll(\PDO::FETCH_CLASS, PostModel::class);
    }

    public static function withHashtag(string $hashtag, $sort="post.created_at", $order="DESC"): array
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
            ORDER BY $sort $order
        ");

        $userId= Session::get("user");

        $statement->bindValue(":name", $hashtag);
        $statement->bindValue(":user_id", $userId);
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