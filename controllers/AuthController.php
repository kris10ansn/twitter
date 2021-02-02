<?php

namespace app\controllers;

use app\models\LoginFormModel;
use app\models\RegisterFormModel;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class AuthController extends \app\src\Controller
{
    public function login(): string
    {
        $loginForm = new LoginFormModel();

        if (Request::getMethod() === Request::METHOD_POST) {
            $request = Request::getBody();
            $loginForm->loadData($request);

            if ($loginForm->validate() && $loginForm->login()) {
                $user = Session::getUser();
                Session::setFlash("success", "Welcome back, $user->firstname!");
                Response::redirect("/");
            }
        }

        return $this->render("login", "app", [
            "model" => $loginForm,
            "title" => "Log in"
        ]);
    }

    public function register(): string
    {
        $registerForm = new RegisterFormModel();

        if (Request::getMethod() === Request::METHOD_POST) {
            $request = Request::getBody();
            $registerForm->loadData($request);

            if ($registerForm->validate() && $registerForm->register()) {
                $user = Session::getUser();
                Session::setFlash("success", "Welcome, $user->firstname!");
                Response::redirect("/");
            }
        }

        return $this->render("register", "app", [
            "model" => $registerForm,
            "title" => "Register a new account"
        ]);
    }

    public function logout()
    {
        Session::logout();
        Response::redirect("/");
    }
}