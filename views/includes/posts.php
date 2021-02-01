<?php
/** @var PostModel[] $posts */

use app\models\PostModel;
use app\views\components\PostComponent;

?>

<link rel="stylesheet" href="styles/includes/posts.css">

<div id="posts">
    <?php foreach ($posts as $post) {
        echo new PostComponent($post);
    }?>
</div>