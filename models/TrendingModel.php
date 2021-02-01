<?php


namespace app\models;


use app\src\Database;
use PDO;

class TrendingModel
{
    public static function getTop(int $n = 6): array
    {
        $db = Database::getInstance();

        // Fant ikke en måte å ta (select count(*) from hashtagged....) as likes
        // for å så ta (posts+likes) as score, så tok det heller direkte inn,
        // for å så sette likes manuelt etterpå. Blir sånn om jeg ikke finner
        // bedre løsning
        $statement = $db->pdo->prepare("
            SELECT
                name,
                COUNT(name) as posts,
                (COUNT(name) + (
                    SELECT count(*)
                    FROM hashtagged as h
                        JOIN post ON post.id = h.post_id
                        JOIN `like` ON `like`.`post_id`=post.id
                    WHERE h.name=hashtagged.name
                )) as score
            FROM hashtagged GROUP BY name ORDER BY score DESC LIMIT 0, $n
        ");

        $statement->execute();

        $top = $statement->fetchAll(\PDO::FETCH_OBJ);

        foreach ($top as $item) {
            $item->likes = $item->score - $item->posts;
        }

        return $top;
    }
}