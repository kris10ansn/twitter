<?php


namespace app\controllers;


use app\models\PostModel;
use app\models\TrendingModel;
use app\models\UserModel;
use app\src\Path;
use app\src\Request;
use app\src\Session;

class UserController extends \app\src\Controller
{
    public function user(): string
    {
        $path = Request::getPath();
        $userId = Path::getParameter($path);

        $user = UserModel::from($userId);

        $data = [
            "user" => $user,
            "posts" => PostModel::postedBy($user),
            "trending" => TrendingModel::getTop(),

        ];

        $appLayout = $this->renderLayout("app", $data);
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("user", $mainLayout, $data);
    }

    public function follow(): string
    {
        if (Request::getMethod() === Request::METHOD_POST) {
            $path = Request::getPath();
            $followId = Path::getParameter($path);
            $user = Session::getUser();

            if (!$user->follows($followId)) {
                $user->follow($followId);
            } else {
                $user->unfollow($followId);
            }
        }

        return "<script>window.history.back();</script>";
    }
}