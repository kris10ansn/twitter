<?php


namespace app\controllers;


use app\models\Post;
use app\src\Request;
use app\src\Response;
use app\src\Router;
use app\src\Session;

class InteractionController extends \app\src\Controller
{
    public function interact()
    {
        if (Request::getMethod() === "post") {
            $user = Session::getUser();
            $body = Request::getBody();
            $postId = Request::getParameter(Request::METHOD_GET, "post_id");

            if ($user === null) {
                Response::redirect("/login");
                return;
            }

            if (isset($body["like"]) && is_numeric($postId)) {
                if (Post::userHasLiked($user->id, $postId)) {
                    Post::unlike($user->id, $postId);
                } else {
                    Post::like($user->id, $postId);
                }
            } else {
                die("400 Bad request");
            }
        } else {
            die("403 Forbidden route");
        }

        echo "<script>window.history.back();</script>";
    }
}