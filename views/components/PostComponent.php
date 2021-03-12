<?php


namespace app\views\components;


use app\models\PostModel;
use app\src\Session;
use app\src\util\Text;
use app\src\util\Time;

/**
 * Class PostComponent
 * @package app\views\components
 */
class PostComponent
{
    private string $heart = "❤️";
    private string $comment = "💬";
    private PostModel $post;
    private bool $list;

    /**
     * PostComponent constructor.
     * @param PostModel $post
     * @param bool $list
     */
    public function __construct(PostModel $post, $list = true)
    {
        $this->post = $post;
        $this->list = $list;
    }

    public function __toString(): string
    {
        $liked = $this->post->liked ? "liked" : "";
        $processedText = Text::render($this->post->text);

        preg_match_all("/@\[(\d+)](\w+)/", $this->post->text, $matches);
        $user = Session::getUser();

        $mentioned = "";

        if (isset($matches) && isset($matches[2]) && $user !== null) {
            foreach ($matches[1] as $id) {
                if ((int) $id === $user->id) {
                    $mentioned = "mentioned";
                }
            }
        }

        $time = strtotime($this->post->created_at);
        $date = Time::since($time);

        $numReplies = $this->post->numberOfReplies();
        $replies = $numReplies > 0 ? " ($numReplies replies)" : "";
        $viewLink = $this->list? "<a href='post/{$this->post->id}' class='view-post'>View post$replies</a>" : "";

        $replyMessage = "";

        if (!$this->list && $this->post->reply_id !== null) {
            $parentPost = PostModel::from($this->post->reply_id);
            $replyMessage = "<p class='reply-message'>
                                Replying to
                                <a href='user/{$parentPost->user_id}'>@{$parentPost->username}</a>'s post
                                (<a href='post/{$parentPost->id}'>view</a>)
                             </p>";
        }

        return "<div class='card post {$mentioned}'>
            <form action='interact/{$this->post->id}' id='{$this->post->id}' method='post'></form>
            <div class='top'>
                <div class='user'>
                    <b>{$this->post->firstname} {$this->post->lastname}</b>
                    (<a href='user/{$this->post->user_id}'>@{$this->post->username}</a>)
                </div>
                <div class='spacer'></div>
                <div class='date'>{$date}</div>
                <div class='mention'>@</div>
            </div>
            $replyMessage
            <div class='text'>
                {$processedText}
            </div>
            <div class='buttons'>
                  <!-- Knappen er knyttet opp mot form-et med id lik postens id (det over) -->
                  <button class='like {$liked}' name='like' type='submit' form='{$this->post->id}'>
                    {$this->heart}{$this->post->likes}
                  </button>
                  $viewLink
                  <a href='post/{$this->post->id}'>
                      <button class='comment'>
                        {$this->comment}
                      </button>
                  </a>
            </div>
        </div>";
    }
}
?>

<link rel="stylesheet" href="styles/components/post.css">

