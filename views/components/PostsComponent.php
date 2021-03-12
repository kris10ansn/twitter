<?php


namespace app\views\components;


use app\models\PostModel;

/**
 * Class PostsComponent
 * @package app\views\components
 */
class PostsComponent
{
    private array $posts;
    private array $args;

    /**
     * PostsComponent constructor.
     * @param PostModel[] $posts
     * @param ...$args
     */
    public function __construct(array $posts, ...$args)
    {
        $this->posts = $posts;
        $this->args = $args;
    }

    public function __toString(): string
    {
        $postStrings = array_map(
            fn($post) => new PostComponent($post, ...$this->args),
            $this->posts
        );

        $postsString = implode("", $postStrings);

        return "
            <div class='posts'>
                {$postsString}
            </div>
        ";
    }
}
?>
<link rel="stylesheet" href="styles/components/posts.css">

