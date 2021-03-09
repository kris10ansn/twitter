
<?php
/** @var LoginFormModel $model */

use app\models\form\LoginFormModel;
use app\views\components\form\Form;

$form = new Form("", "post", $model);
?>

<h1>Log in</h1>

<?= $form->begin() ?>
    <?= $form->inputField("email", "E-mail") ?>
    <?= $form->inputField("password", "Password")->password() ?>
    <button type="submit">Log in</button>
<?= $form->end() ?>

<p>Don't have an account? <a href="register">Register</a></p>