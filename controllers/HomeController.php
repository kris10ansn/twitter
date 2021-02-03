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

        $appLayout = $this->renderLayout("app", $data);
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("home", $mainLayout, $data);
    }

    public function explore()
    {
        $data = [
            "posts" => PostModel::all(),
            "trending" => TrendingModel::getTop()
        ];

        $appLayout = $this->renderLayout("app", $data);
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("explore", $mainLayout, $data);
    }
}