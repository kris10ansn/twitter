<?php


namespace app\views\components;


use app\models\PostFormModel;
use app\models\PostModel;
use app\src\Session;

class PostComponent
{
    private string $heart = "❤️";
    private string $comment = "💬";
    private PostModel $post;

    public function __construct(PostModel $post)
    {
        $this->post = $post;
    }

    public function __toString(): string
    {
        $liked = $this->post->liked ? "liked" : "";
        $processedText = preg_replace(
            [PostFormModel::HASHTAG_REGEX, "/@\[(\d+)](\w+)/"],
            ['<a href="hashtag/$1">#$1</a>', '<a href="user/$1">@$2</a>'],
            $this->post->text
        );

        preg_match_all("/@\[(\d+)](\w+)/", $this->post->text, $matches);
        $user = Session::getUser();

        $mentioned = "";

        if (isset($matches) && isset($matches[2]) && $user !== null) {
            foreach ($matches[2] as $match) {
                if (strtolower($match) === strtolower($user->username)) {
                    $mentioned = "mentioned";
                }
            }
        }

        return "<div class='card post {$mentioned}'>
            <form action='interact/{$this->post->id}' id='{$this->post->id}' method='post'></form>
            <div class='top'>
                <div class='user'>
                    <b>{$this->post->firstname} {$this->post->lastname}</b>
                    (<a href='user/{$this->post->user_id}'>@{$this->post->username}</a>)
                </div>
                <div class='spacer'></div>
                <div class='mention'>@</div>
            </div>
            <div class='text'>
                {$processedText}
            </div>
            <div class='buttons'>
                  <!-- Knappen er knyttet opp mot form-et med id lik postens id (det over) -->
                  <button class='like {$liked}' name='like' type='submit' form='{$this->post->id}'>
                    {$this->heart}{$this->post->likes}
                  </button>
                  <a href='post/{$this->post->id}'>
                      <button class='comment'>
                        {$this->comment}
                      </button>
                  </a>
            </div>
        </div>";
    }
}