<?php


namespace app\controllers;


use app\models\Hashtag;
use app\models\PostModel;
use app\models\TrendingModel;
use app\src\Controller;
use app\src\Path;
use app\src\Request;

class HashtagController extends Controller
{
    public function hashtag(): string
    {
        $path = Request::getPath();
        $hashtag = Path::getParameter($path);

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

        $appLayout= $this->renderLayout("app");
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("hashtag", $mainLayout, $data);
    }
}