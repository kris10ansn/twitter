<?php


namespace app\controllers;


use app\models\PostModel;
use app\models\TrendingModel;
use app\models\UserModel;
use app\src\Path;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class UserController extends \app\src\Controller
{
    public function users(): string
    {
        $sort = UserModel::SORT_FOLLOWERS;
        $sortParam = Request::getParameter(Request::METHOD_GET, "sort");

        if ($sortParam === "new") {
            $sort = "user.created_at";
        }

        $users = UserModel::all($sort, "DESC");

        $data = [
            "trending" => TrendingModel::getTop(),
            "users" => $users
        ];

        $appLayout = $this->renderLayout("app", $data);
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("users", $mainLayout, $data);
    }

    public function user(): string
    {
        $path = Request::getPath();
        $userId = Path::getParameter($path);

        if (is_numeric($userId)) {
            $user = UserModel::from(intval($userId));
        }

        $trending = TrendingModel::getTop();

        if (!isset($user) || !$user) {
            $appLayout = $this->renderLayout("app");
            $mainLayout = $this->renderLayoutInside($appLayout, "main", ["trending" => $trending]);
            return $this->renderText("<h1>User not found</h1>", $mainLayout);
        }

        $data = [
            "user" => $user,
            "posts" => PostModel::postedBy($user),
            "trending" => $trending,
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

            if ($user === null) {
                Response::redirect("/login");
            }

            if (!$user->follows($followId)) {
                $user->follow($followId);
            } else {
                $user->unfollow($followId);
            }
        }

        return "<script>window.history.back();</script>";
    }
}