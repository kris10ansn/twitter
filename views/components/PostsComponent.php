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

    /**
     * PostsComponent constructor.
     * @param PostModel[] $posts
     */
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public function __toString(): string
    {
        $postStrings = array_map(
            fn($post) => new PostComponent($post),
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

