<?php
/** @var PostFormModel $postModel */
/** @var Post[] $posts */

use app\models\Post;
use app\models\PostFormModel;
use app\src\Session;

$user = Session::getUser()

?>

<link rel="stylesheet" href="/styles/views/home.css">

<div id="content">
    <main>
        <script>
            function onSubmit() {
                const textarea = document.querySelector("#new-post textarea");
                const contentEditable = document.querySelector("#new-post div[contenteditable]");

                textarea.value = contentEditable.textContent;
            }
        </script>

        <div id="new-post" class="card">
            <?php if ($user !== null): ?>
                <form action="" method="post" onsubmit="onSubmit()">
                    <div id="input">
                        <div contenteditable data-placeholder="What's on your mind?"></div>
                        <button type="submit">Post</button>
                    </div>
                    <textarea name="text"></textarea>
                    <p class="error"><?= $postModel->getFirstError("text") ?></p>
                </form>
            <?php else: ?>
                <p>Log in to post</p>
            <?php endif; ?>
        </div>

        <div id="posts">
            <?php foreach ($posts as $post): ?>
                <div class="card post">
                    <form action="/interact?post_id=<?= $post->id ?>" method="post" id="<?= $post->id ?>" style="display: none"></form>
                    <p>
                        <b><?= "$post->firstname $post->lastname" ?> (@<?= $post->username ?>)</b>
                    </p>
                    <div class="text">
                        <?= $post->text ?>
                    </div>
                    <div class="buttons">
                        <button class="like <?= $post->liked ? "liked" : "" ?>" type="submit" form="<?= $post->id ?>" name="like">
                            ❤️<?= $post->likes ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <aside>
        <div id="trending" class="card">
            <h1>Trending</h1>
        </div>
    </aside>
</div>