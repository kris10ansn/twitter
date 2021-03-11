<link rel="stylesheet" href="styles/views/edit-profile.css">

<h1>Edit profile</h1>

<?php

/** @var EditProfileFormModel $model */
/** @var UserModel[] $users */

use app\models\form\EditProfileFormModel;
use app\models\UserModel;
use app\views\components\form\Form;

$form = new Form("", "post", $model);
?>

<?= $form->begin() ?>
    <?= $form->inputField("username", "Username") ?>
    <?= $form->textAreaField("biography", "Bio", "4", "30") ?>
    <?= $form->inputField("email", "E-mail") ?>

    <label for="favorite_user">Favorite user</label>
    <select name="favorite_user" id="favorite_user">
        <?php if ($model->fields["favorite_user"] === "0"): ?>
            <option value="" disabled selected hidden>Select your favorite user</option>
        <?php endif; ?>
        <?php foreach ($users as $user): ?>
            <option
                    value="<?= $user->id ?>"
                    <?= $model->fields["favorite_user"] == $user->id ? "selected" : "" ?>
            >
                <?= $user->firstname ?> <?= $user->lastname ?> (@<?= $user->username ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Apply changes</button>
<?= $form->end() ?>
