<?php
/** @var RegisterFormModel $model */

use app\models\form\RegisterFormModel;
use app\views\components\form\Form;

$form = new Form("", "post", $model);
?>

<h1>Register</h1>

<?= $form->begin() ?>
    <?= $form->inputField("firstname", "First name") ?>
    <?= $form->inputField("lastname", "Last name") ?>
    <?= $form->inputField("username", "Username") ?>
    <?= $form->inputField("email", "E-mail") ?>
    <?= $form->inputField("password", "Password")->password() ?>
    <button type="submit">Register</button>
<?= $form->end() ?>
