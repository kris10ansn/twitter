<?php
/** @var UserModel $user */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\form\PostFormModel;
use app\models\PostModel;
use app\models\UserModel;

?>

<h1>Explore</h1>

<?php
include_once constant("APP_ROOT") . "/views/includes/sort.php";

sort_options();
?>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>
