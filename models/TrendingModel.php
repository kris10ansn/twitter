<?php


namespace app\models;


use app\src\Database;
use PDO;

/**
 * Class TrendingModel
 * @package app\models
 */
class TrendingModel
{
    public static function getTop(int $n = 6): array
    {
        $db = Database::getInstance();

        $statement = $db->prepare("
            SELECT
                name, posts, likes, (posts + likes) as score
            FROM hashtagged
                JOIN (
                    SELECT
                        count(_hashtagged.name) as posts, _hashtagged.name as _name,
                        (SELECT count(*) FROM hashtagged _h
                         JOIN `like` ON `like`.post_id=_h.post_id
                         WHERE _h.name=_hashtagged.name) as likes
                    FROM hashtagged _hashtagged
                    GROUP BY _name
                ) as info ON info._name=hashtagged.name
            GROUP BY name
            ORDER BY score DESC
            LIMIT 0, $n
        ");

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}