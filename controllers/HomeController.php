<?php


namespace app\controllers;

use app\models\PostFormModel;
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

        return $this->render("home", [
            "postModel" => $postModel
        ]);
    }
}