<link rel="stylesheet" href="styles/views/home.css">

<?php
/** @var UserModel $user */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\form\PostFormModel;
use app\models\PostModel;
use app\models\UserModel;
use app\src\Session;
use app\views\components\BigInputComponent;

$user = Session::getUser();
?>

<?php if ($user !== null): ?>   
    <h1>Following</h1>
<?php endif; ?>

<div id="top-card" class="card">
    <?php if ($user !== null): ?>
        <?= new BigInputComponent($postFormModel, "What&#39;s on your mind?") ?>
    <?php else: ?>
        <p><a href="login">Log in</a> to post and follow users. <a href="explore">Explore</a>.</p>
    <?php endif; ?>
</div>

<?php if ($user !== null): ?>
    <?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>

    <div class="card">
        <p><a href="users">Follow someone</a> to see more posts here. </p>
    </div>
<?php endif; ?>