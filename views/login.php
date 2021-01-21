
<?php
/** @var LoginForm $model */

use app\models\LoginForm;

?>

<h1>Log in</h1>

<form action="" method="post">
    <label>
        E-mail
        <input type="text" name="email" value="<?= $model->fields["email"] ?>">
        <p class="error"><?= isset($model->errors["email"]) ? $model->errors["email"] : "" ?></p>
    </label>
    <label>
        Password
        <input type="password" name="password" value="<?= $model->fields["password"] ?>">
        <p class="error"><?= isset($model->errors["password"]) ? $model->errors["password"] : "" ?></p>
    </label>

    <button type="submit">Log in</button>
</form>