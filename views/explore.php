<?php
/** @var UserModel $user */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\form\PostFormModel;
use app\models\PostModel;
use app\models\UserModel;
use app\views\components\SortOptions;

?>

<h1>Explore</h1>

<?= new SortOptions() ?>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>
