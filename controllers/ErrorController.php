<?php


namespace app\controllers;


use app\src\Controller;
use app\src\Response;

class ErrorController extends Controller
{
    public function error404(): string
    {
        Response::statusCode(404);

        $data = [ "error" => "404 Not found" ];

        return $this->render($data, "error", "app");
    }
}