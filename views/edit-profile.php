<h1>Edit profile</h1>

<?php

/** @var EditProfileFormModel $model */

use app\models\form\EditProfileFormModel;
use app\views\components\form\Form;

$form = new Form("", "post", $model);
?>

<?= $form->begin() ?>
    <?= $form->inputField("username", "Username") ?>
    <?= $form->textAreaField("biography", "Bio", "4", "30") ?>
    <?= $form->inputField("email", "E-mail") ?>
    <button type="submit">Apply changes</button>
<?= $form->end() ?>
