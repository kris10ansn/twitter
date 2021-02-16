
<?php
/** @var LoginFormModel $model */

use app\models\LoginFormModel;

?>

<h1>Log in</h1>

<form action="" method="post">
    <label for="email">E-mail</label>
    <input type="text" id="email" name="email" value="<?= $model->fields["email"] ?>">
    <p class="error"><?= $model->getFirstError("email") ?></p>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" value="<?= $model->fields["password"] ?>">
    <p class="error"><?= $model->getFirstError("password") ?></p>

    <button type="submit">Log in</button>
</form>

<p>Don't have an account? <a href="register">Register</a></p>