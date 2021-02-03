<?php


namespace app\controllers;


use app\models\PostModel;
use app\src\Request;
use app\src\Response;
use app\src\Router;
use app\src\Session;

class PostController extends \app\src\Controller
{
    public function interact(): string
    {
        if (Request::getMethod() === Request::METHOD_POST) {
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
            
            $post = PostModel::from($postId);

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

        return "<script>window.history.back();</script>";
    }
}