<?php


namespace app\controllers;


use app\models\UserModel;
use app\src\Path;
use app\src\Request;

class UserController extends \app\src\Controller
{
    public function user(): string
    {
        $path = Request::getPath();
        $userId = Path::getParameter($path);


        $user = UserModel::from($userId);

        return $this->render("user", "app", [
            "user" => $user
        ]);
    }
}