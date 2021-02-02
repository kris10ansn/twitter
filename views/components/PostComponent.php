<?php


namespace app\views\components;


use app\models\PostFormModel;
use app\models\PostModel;

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

        return "<div class='card post'>
            <form action='interact/{$this->post->id}' id='{$this->post->id}' method='post'></form>
            <div class='top'>
                <b>{$this->post->firstname} {$this->post->lastname}</b>
                (<a href='user/{$this->post->user_id}'>@{$this->post->username}</a>)
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