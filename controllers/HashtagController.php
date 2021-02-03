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

        $trending = TrendingModel::getTop();

        $data = [
            "posts" => PostModel::withHashtag($hashtag),
            "trending" => $trending,
            "hashtag" => $hashtag
        ];

        $appLayout= $this->renderLayout("app");
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("hashtag", $mainLayout, $data);
    }
}