<?php


namespace app\controllers;

use app\models\Post;
use app\models\PostFormModel;
use app\models\Trending;
use app\src\Controller;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class HomeController extends Controller
{
    public function home(): string
    {

        $postModel = new PostFormModel();

        if (Request::getMethod() === "post") {
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

        $posts = Post::all();

        $trending = Trending::getTop(6);

        return $this->render("home", [
            "postModel" => $postModel,
            "posts" => $posts,
            "trending" => $trending
        ]);
    }
}