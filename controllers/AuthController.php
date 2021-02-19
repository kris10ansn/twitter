<?php

namespace app\controllers;

use app\models\form\LoginFormModel;
use app\models\form\RegisterFormModel;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class AuthController extends \app\src\Controller
{
    public const AUTH_REDIRECT = "auth-redirect";

    public function login(): string
    {
        $loginForm = new LoginFormModel();

        if (Request::getMethod() === Request::METHOD_POST) {
            $request = Request::getBody();
            $loginForm->loadData($request);

            if ($loginForm->validate() && $loginForm->login()) {
                $user = Session::getUser();
                Session::setFlash("success", "Welcome back, $user->firstname!");

                $this->redirect();
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

                $this->redirect();
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
        Session::setFlash("success", "Good bye.");
        echo "<script>window.history.back();</script>";
    }

    private function redirect() {
        $redirect = Session::get(self::AUTH_REDIRECT) ?? "/";
        Session::remove(self::AUTH_REDIRECT);
        Response::redirect($redirect);
    }
}