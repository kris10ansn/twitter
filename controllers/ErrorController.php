<?php


namespace app\controllers;


use app\src\Response;

class ErrorController extends \app\src\Controller
{
    public function error404()
    {
        Response::statusCode(404);

        $appLayout = $this->renderlayout("app");

        return $this->renderText("<h1>404 Not found</h1>", $appLayout);
    }
}