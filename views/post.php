<?php
/** @var PostModel $post */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\form\PostFormModel;
use app\models\PostModel;
use app\views\components\BigInputComponent;
use app\views\components\PostComponent;
use app\views\components\PostsComponent;

?>

<link rel="stylesheet" href="styles/components/post.css">

<?= new PostComponent($post, false) ?>

<div class="card">
    <?= new BigInputComponent($postFormModel, "Reply to @{$post->username}&#39;s post") ?>
</div>

<?= new PostsComponent($posts) ?>