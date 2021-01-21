<?php

namespace app\controllers;

use app\models\LoginForm;
use app\src\Request;

class AuthController extends \app\src\Controller
{
    public function login(): string
    {
        $loginForm = new LoginForm();

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
        if (Request::getMethod() === "post") {
            return "Handling post...";
        }

        return $this->render("register");
    }
}