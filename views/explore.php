<?php
/** @var UserModel $user */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\PostFormModel;
use app\models\PostModel;
use app\models\UserModel;
?>

<link rel="stylesheet" href="styles/views/explore.css">

<h1>Explore</h1>

<form id="sort" method="get">
    <button class="option" name="sort" value="top">Top</button>
    <button class="option" name="sort" value="new">New</button>
</form>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>
