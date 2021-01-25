<?php
/** @var PostFormModel $postModel */

use app\models\PostFormModel;

?>

<h1>Home</h1>

<form id="new-post" action="" method="post">
    <textarea name="text" cols="30" rows="10"></textarea>
    <p class="error"><?= $postModel->getFirstError("text") ?></p>
    <button type="submit">Post</button>
</form>