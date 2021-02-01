<?php
/** @var PostFormModel $postModel */
/** @var PostModel[] $posts */
/** @var object[] $trending */

use app\models\PostModel;
use app\models\PostFormModel;
use app\src\Session;
use app\views\components\PostComponent;

$user = Session::getUser()

?>

<link rel="stylesheet" href="styles/views/home.css">

<?php include constant("APP_ROOT") . "/views/includes/new-post.php"; ?>

<div id="posts">
    <?php foreach ($posts as $post) {
        echo new PostComponent($post);
    }?>
</div>