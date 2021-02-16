<?php


namespace app\controllers;


use app\models\PostFormModel;
use app\models\PostModel;
use app\models\TrendingModel;
use app\src\Request;
use app\src\Response;
use app\src\Session;

class PostController extends \app\src\Controller
{
    public function post(array $parameters): string
    {
        $postFormModel = new PostFormModel();
        $request = Request::getBody();

        $postId = $parameters["id"];
        $post = PostModel::from($postId);

        if (Request::getMethod() === Request::METHOD_POST) {
            $postFormModel->loadData($request);
            $postFormModel->fields["reply_id"] = $postId;

            if ($postFormModel->validate() && $postFormModel->post()) {
                $postFormModel->fields["text"] = "";
                $postFormModel->fields["user_id"] = "";

                Response::redirect("/post/$postId");
            }
        }

        $data = [
            "trending" => TrendingModel::getTop(),
            "post" => $post,
            "posts" => $post->getReplies(),
            "title" => "Twitter | Post by $post->firstname $post->lastname",
            "postFormModel" => $postFormModel
        ];

        $appLayout = $this->renderLayout("app", $data);
        $layout = $this->renderLayoutInside($appLayout, "main", $data);

        return $this->renderView("post", $layout, $data);
    }
    
    public function interact(array $parameters): string
    {
        if (Request::getMethod() === Request::METHOD_POST) {
            $user = Session::getUser();

            if ($user === null) {
                Response::redirect("/login");
                return "";
            }

            $body = Request::getBody();
            $postId = $parameters["id"];
            
            $post = PostModel::from($postId);

            if (isset($body["like"]) && $post !== null) {
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