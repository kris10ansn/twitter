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

<div id="content">
    <main>
        <script>
            function onSubmit() {
                const textarea = document.querySelector("#new-post textarea");
                const contentEditable = document.querySelector("#new-post div#text-input");

                textarea.value = contentEditable.textContent;
            }
        </script>

        <div id="new-post" class="card">
            <?php if ($user !== null): ?>
                <form action="" method="post" onsubmit="onSubmit()">
                    <div id="input">
                        <div contenteditable data-placeholder="What's on your mind?" id="text-input"><?= $postModel->fields["text"] ?></div>
                        <button type="submit">Post</button>
                    </div>
                    <textarea name="text"></textarea>
                    <p class="error"><?= $postModel->getFirstError("text") ?></p>
                </form>
            <?php else: ?>
                <p><a href="login">Log in</a> to post</p>
            <?php endif; ?>
        </div>

        <div id="posts">
            <?php foreach ($posts as $post) {
                echo new PostComponent($post);
            }?>
        </div>
    </main>
    <aside>
        <div id="trending" class="card">
            <h1>Trending</h1>
            <hr>
            <?php foreach ($trending as $hashtag): ?>
                <a href="hashtag/<?= $hashtag->name ?>">
                    <div class="hashtag">
                        #<?= $hashtag->name ?>
                        <p class="small"><?= $hashtag->posts ?> posts, <?= $hashtag->likes ?> likes</p>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (count($trending) === 0): ?>
                <p>Try posting a <a>#hasthag</a> to get on trending!</p>
            <?php endif; ?>
        </div>
    </aside>
</div>