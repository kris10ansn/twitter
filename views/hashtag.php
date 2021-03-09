<?php
/** @var string $hashtag */
?>

<h1>Posts with <a href="hashtag/<?= $hashtag?>">#<?= $hashtag ?></a></h1>

<?php
include_once constant("APP_ROOT") . "/views/includes/sort.php";

sort_options();
?>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>