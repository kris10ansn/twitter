<?php
/** @var string $hashtag */
/** @var PostModel[] $posts */

use app\models\PostModel;
use app\views\components\PostsComponent;
use app\views\components\SortOptions;

?>

<h1>Posts with <a href="hashtag/<?= $hashtag?>">#<?= $hashtag ?></a></h1>

<?= new SortOptions() ?>

<?= new PostsComponent($posts) ?>