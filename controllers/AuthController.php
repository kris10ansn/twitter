<?php

namespace app\controllers;

use app\models\LoginFormModel;
use app\models\RegisterFormModel;
use app\src\Request;

class AuthController extends \app\src\Controller
{
    public function login(): string
    {
        $loginForm = new LoginFormModel();

        if (Request::getMethod() === "post") {
            $request = Request::getBody();
            $loginForm->loadData($request);

            if ($loginForm->validate()) {
                return "Valid data bro!";
            }
        }

        return $this->render("login", [
            "model" => $loginForm
        ]);
    }

    public function register(): string
    {
        $registerForm = new RegisterFormModel();

        if (Request::getMethod() === "post") {
            $request = Request::getBody();
            $registerForm->loadData($request);

            if ($registerForm->validate()) {
                return "Valid data bro!";
            }
        }

        return $this->render("register", [
            "model" => $registerForm
        ]);
    }
}