
<?php
/** @var LoginFormModel $model */

use app\models\LoginFormModel;

?>

<h1>Log in</h1>

<form action="" method="post">
    <label>
        E-mail
        <input type="text" name="email" value="<?= $model->fields["email"] ?>">
        <p class="error"><?= $model->getFirstError("email") ?></p>
    </label>
    <label>
        Password
        <input type="password" name="password" value="<?= $model->fields["password"] ?>">
        <p class="error"><?= $model->getFirstError("password") ?></p>
    </label>

    <button type="submit">Log in</button>
</form>

<p>Don't have an account? <a href="/register">Register</a></p>