<?php
/** @var string $hashtag */

use app\views\components\SortOptions;

?>

<h1>Posts with <a href="hashtag/<?= $hashtag?>">#<?= $hashtag ?></a></h1>

<?= new SortOptions() ?>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>