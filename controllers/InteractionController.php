<?php


namespace app\controllers;


use app\models\Post;
use app\src\Request;
use app\src\Response;
use app\src\Router;
use app\src\Session;

class InteractionController extends \app\src\Controller
{
    public function interact(): string
    {
        if (Request::getMethod() === "post") {
            $user = Session::getUser();

            if ($user === null) {
                Response::redirect("/login");
                return "";
            }

            $body = Request::getBody();
            preg_match("/interact\/(.+)/", Request::getPath(), $matches);

            if (count($matches) > 0 && is_numeric($matches[1])) {
                $postId = (int)$matches[1];
            } else {
                return "400 Bad request";
            }
            
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