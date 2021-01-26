<?php
/** @var PostFormModel $postModel */
/** @var Post[] $posts */

use app\models\Post;
use app\models\PostFormModel;
use app\src\Session;

$user = Session::getUser()

?>

<link rel="stylesheet" href="/styles/views/home.css">
<h1>Home</h1>

<?php if ($user !== null): ?>
    <p>Post as @<?= $user->username ?>:</p>
    <form id="new-post" action="" method="post">
        <textarea name="text" cols="30" rows="10"></textarea>
        <p class="error"><?= $postModel->getFirstError("text") ?></p>
        <button type="submit">Post</button>
    </form>
<?php else: ?>
    <p>Log in to post</p>
 <?php endif; ?>

<div id="posts">
    <?php foreach ($posts as $post): ?>
        <form action="/interact?post_id=<?= $post->id ?>" method="post" id="interact" style="display: none"></form>
        <div class="post">
            <p>
                <b><?= "$post->firstname $post->lastname" ?></b>
            </p>
            <p>
                @<?= $post->username ?>
            </p>
            <div class="text">
                <?= $post->text ?>
            </div>
            <div class="buttons">
                <button type="submit" form="interact" name="like">
                    <?= $post->liked ? "Liked" : "Like" ?>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>