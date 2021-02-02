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
        $user = Session::getUser();


        if (Request::getMethod() === Request::METHOD_POST) {
            if ($user === null) {
                die("Not logged in");
            }

            $request = Request::getBody();
            $postModel->loadData($request);

            if ($postModel->validate() && $postModel->post()) {
                Response::redirect("/");
            }
        }

        if ($user) {
            $posts = PostModel::feed($user->id);
        } else {
            $posts = PostModel::all();
        }


        $trending = TrendingModel::getTop();

        $data = [
            "postFormModel" => $postModel,
            "posts" => $posts,
            "trending" => $trending
        ];

        $appLayout = $this->renderLayout("app", $data);
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("home", $mainLayout, $data);
    }
}