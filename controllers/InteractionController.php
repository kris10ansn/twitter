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

            if ($user === null) {
                Response::redirect("/login");
                return;
            }

            $body = Request::getBody();
            $postId = Request::getParameter(Request::METHOD_GET, "post_id");
            $post = Post::from($postId);

            if (isset($body["like"]) && is_numeric($postId)) {
                if ($post->likedBy($user)) {
                    $post->unlike($user);
                } else {
                    $post->like($user);
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