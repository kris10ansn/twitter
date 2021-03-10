<?php


namespace app\controllers;


use app\models\form\EditProfileFormModel;
use app\models\PostModel;
use app\models\TrendingModel;
use app\models\UserModel;
use app\src\Request;
use app\src\Response;
use app\src\Session;
use app\src\util\Text;

/**
 * Class UserController
 * @package app\controllers
 */
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

        return $this->render($data, "edit-profile", "app", "main");
    }

    public function users(): string
    {
        $sort = UserModel::SORT_FOLLOWERS;
        $sortParam = Request::getParameter(Request::METHOD_GET, "sort");

        if ($sortParam === "new") {
            $sort = "user.created_at";
        }

        $me = Session::getUser();
        $users = UserModel::all($sort, "DESC");

        // Viser kun "to follow" hvis du er logget inn
        $data = [
            "text" => "Users" . ($me === null ? "" : " to follow"),
            "trending" => TrendingModel::getTop(),
            "users" => $users,
        ];

        return $this->render($data, "users", "app", "main");
    }

    public function user(array $parameters): string
    {
        $userId = $parameters["id"];

        if (is_numeric($userId)) {
            $user = UserModel::from(intval($userId));
        }

        return $this->renderUser($user ?? null);
    }

    /**
     * @return string|string[]
     */
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

    /**
     * @param UserModel|null $user
     * @return string|string[]
     */
    private function renderUser(?UserModel $user) {
        $trending = TrendingModel::getTop();

        if ($user === null) {
            $data = [
                "error" => "User not found",
                "trending" => $trending
            ];

            return $this->render($data, "error", "app", "main");
        }

        $data = [
            "user" => $user,
            "posts" => PostModel::postedBy($user),
            "trending" => $trending,
        ];

        return $this->render($data, "user", "app", "main");
    }

    public function followers(array $parameters): string
    {
        $user = UserModel::from($parameters["id"]);

        $data = [
            "trending" => TrendingModel::getTop(),
            "text" => Text::process("These people follow @{$user->username}"),
            "users" => $user->followers()
        ];

        return $this->render($data, "users", "app", "main");
    }

    public function following(array $parameters): string
    {
        $user = UserModel::from($parameters["id"]);

        $data = [
            "trending" => TrendingModel::getTop(),
            "text" => Text::process("@{$user->username} follows these users:"),
            "users" => $user->following()
        ];

        return $this->render($data, "users", "app", "main");
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

            if ($user->id === intval($followId)) {
                return "<script>window.history.back()</script>";
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