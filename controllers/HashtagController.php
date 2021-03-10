<?php


namespace app\controllers;


use app\models\PostModel;
use app\models\TrendingModel;
use app\src\Controller;
use app\src\Request;

/**
 * Class HashtagController
 * @package app\controllers
 */
class HashtagController extends Controller
{
    public function hashtag(array $parameters): string
    {
        $hashtag = $parameters["hashtag"];
        $sort = "likes";
        $sortParam = Request::getParameter(Request::METHOD_GET, "sort");

        if ($sortParam === "new") {
            $sort = "post.created_at";
        }

        $data = [
            "posts" => PostModel::withHashtag($hashtag, $sort),
            "trending" => TrendingModel::getTop(),
            "hashtag" => $hashtag
        ];

        return $this->render($data, "hashtag", "app", "main");
    }
}