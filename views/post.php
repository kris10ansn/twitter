<?php
/** @var PostModel $post */
/** @var PostFormModel $postFormModel */

use app\models\PostFormModel;
use app\models\PostModel;
use app\views\components\BigInputComponent;
use app\views\components\PostComponent;

?>

<link rel="stylesheet" href="styles/components/post.css">

<?= new PostComponent($post, false) ?>

<div class="card">
    <?= new BigInputComponent($postFormModel, "Reply to @{$post->username}&#39;s post") ?>
</div>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>