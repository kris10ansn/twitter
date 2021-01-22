<?php
/** @var RegisterFormModel $model */

use app\models\RegisterFormModel;

?>

<h1>Register</h1>

<form action="" method="post">
    <label>
        First name
        <input type="text" name="firstname" value="<?= $model->fields["firstname"] ?>">
    </label>
    <p class="error"><?= $model->getFirstError("firstname") ?></p>

    <label>
        Last name
        <input type="text" name="lastname" value="<?= $model->fields["lastname"] ?>">
    </label>
    <p class="error"><?= $model->getFirstError("lastname") ?></p>

    <label>
        Display name
        <input type="text" name="username" value="<?= $model->fields["username"] ?>">
    </label>
    <p class="error"><?= $model->getFirstError("lastname") ?></p>

    <label>
        E-mail
        <input type="text" name="email" value="<?= $model->fields["email"] ?>">
    </label>
    <p class="error"><?= $model->getFirstError("email") ?></p>

    <label>
        Password
        <input type="password" name="password" value="<?= $model->fields["password"] ?>">
    </label>
    <p class="error"><?= $model->getFirstError("password") ?></p>

    <button type="submit">Register</button>
</form>