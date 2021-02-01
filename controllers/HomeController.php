<?php


namespace app\controllers;

use app\models\PostModel;
use app\models\PostFormModel;
use app\models\TrendingModel;
use app\src\Controller;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class HomeController extends Controller
{
    public function home(): string
    {

        $postModel = new PostFormModel();

        if (Request::getMethod() === Request::METHOD_POST) {
            $user = Session::getUser();

            if ($user === null) {
                die("Not logged in");
            }

            $request = Request::getBody();
            $postModel->loadData($request);

            if ($postModel->validate() && $postModel->post()) {
                Response::redirect("/");
            }
        }

        $posts = PostModel::all();

        $trending = TrendingModel::getTop(6);

        $data = [
            "postModel" => $postModel,
            "posts" => $posts,
            "trending" => $trending
        ];

        $mainLayout = $this->renderLayout("main", $data);
        $postsLayout = $this->renderLayoutInside($mainLayout, "posts", $data);

        return $this->renderView("home", $postsLayout, $data);
    }
}