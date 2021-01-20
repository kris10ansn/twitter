<?php

namespace app\controllers;

use app\src\Request;

class AuthController extends \app\src\Controller
{
    public function login(): string
    {
        if (Request::getMethod() === "post") {
            return "Handling post...";
        }

        return $this->render("login");
    }

    public function register(): string
    {
        if (Request::getMethod() === "post") {
            return "Handling post...";
        }

        return $this->render("register");
    }
}