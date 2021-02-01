<?php
/** @var UserModel $user */
/** @var PostFormModel $postModel */

use app\models\PostFormModel;
use app\models\UserModel;
?>

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
            <!-- PHPStorm klager på at jeg ikke har label element rundt textarea.. -->
            <label>
                <textarea name="text"></textarea>
            </label>
            <p class="error"><?= $postModel->getFirstError("text") ?></p>
        </form>
    <?php else: ?>
        <p><a href="login">Log in</a> to post</p>
    <?php endif; ?>
</div>