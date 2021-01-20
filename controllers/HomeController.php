<?php


namespace app\controllers;

use app\src\Controller;

class HomeController extends Controller
{
    public function home(): string
    {
        return $this->render("home");
    }
}