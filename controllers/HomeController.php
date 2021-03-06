<?php


namespace app\controllers;

use app\models\PostModel;
use app\models\form\PostFormModel;
use app\models\TrendingModel;
use app\src\Controller;
use app\src\Request;
use app\src\Response;
use app\src\Session;

/**
 * Class HomeController
 * @package app\controllers
 */
class HomeController extends Controller
{
    public function home(): string
    {
        $postFormModel = new PostFormModel();
        $user = Session::getUser();


        if (Request::getMethod() === Request::METHOD_POST) {
            if ($user === null) {
                die("Not logged in");
            }

            $request = Request::getBody();
            $postFormModel->loadData($request);

            if ($postFormModel->validate() && $postFormModel->post()) {
                Response::redirect("/");
            }
        }

        $data = [
            "postFormModel" => $postFormModel,
            "posts" => $user ? PostModel::feed($user->id) : null,
            "trending" => TrendingModel::getTop()
        ];

        return $this->render($data, "home", "app", "main");
    }

    public function explore(): string
    {
        $sort = "likes";
        $sortParam = Request::getParameter(Request::METHOD_GET, "sort");

        if ($sortParam === "new") {
            $sort = "post.created_at";
        }

        $data = [
            "posts" => PostModel::all($sort),
            "trending" => TrendingModel::getTop()
        ];

        return $this->render($data, "explore", "app", "main");
    }
}