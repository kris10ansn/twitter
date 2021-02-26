<?php


namespace app\controllers;


use app\models\form\EditProfileFormModel;
use app\models\form\PostFormModel;
use app\models\PostModel;
use app\models\TrendingModel;
use app\models\UserModel;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class UserController extends \app\src\Controller
{
    public function editProfile(): string
    {
        $user = Session::getUser();

        if ($user === null) {
            $path = Request::getPath();
            Session::set(AuthController::AUTH_REDIRECT, $path);
            Response::redirect("/login");
            return "";
        }

        $editProfile = new EditProfileFormModel();

        $data = [
            "trending" => TrendingModel::getTop(),
            "model" => $editProfile,
            "title" => "Twitter | Edit profile"
        ];

        if (Request::getMethod() === Request::METHOD_POST) {
            $request = Request::getBody();
            $editProfile->loadData($request);

            if ($editProfile->validate() && $editProfile->apply()) {
                Response::redirect("/profile");
            }
        } else {
            $editProfile->loadData((array) $user);
        }

        $appLayout = $this->renderLayout("app", $data);
        $mainLayout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("edit-profile", $mainLayout, $data);
    }

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

    public function user(array $parameters): string
    {
        $userId = $parameters["id"];

        if (is_numeric($userId)) {
            $user = UserModel::from(intval($userId));
        }

        return $this->renderUser($user ?? null);
    }

    public function profile()
    {
        $user = Session::getUser();

        if ($user === null) {
            $path = Request::getPath();
            Session::set(AuthController::AUTH_REDIRECT, $path);
            Response::redirect("/login");
        }

        return $this->renderUser($user);
    }

    private function renderUser(?UserModel $user) {
        $trending = TrendingModel::getTop();

        if ($user === null) {
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

    public function follow(array $parameters): string
    {
        if (Request::getMethod() === Request::METHOD_POST) {
            $followId = $parameters["id"];
            $user = Session::getUser();

            if ($user === null) {
                Session::set(AuthController::AUTH_REDIRECT, "/user/{$followId}");
                Response::redirect("/login");
                return "";
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