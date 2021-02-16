<?php
/** @var RegisterFormModel $model */

use app\models\RegisterFormModel;

?>

<h1>Register</h1>

<form action="" method="post">
    <label for="firstname">First name</label>
    <input type="text" id="firstname" name="firstname" value="<?= $model->fields["firstname"] ?>">
    <p class="error"><?= $model->getFirstError("firstname") ?></p>

    <label for="lastname">Last name</label>
    <input type="text" id="lastname" name="lastname" value="<?= $model->fields["lastname"] ?>">
    <p class="error"><?= $model->getFirstError("lastname") ?></p>

    <label for="username">Display name</label>
    <input type="text" id="username" name="username" value="<?= $model->fields["username"] ?>">
    <p class="error"><?= $model->getFirstError("username") ?></p>

    <label for="email">E-mail</label>
    <input type="text" id="email" name="email" value="<?= $model->fields["email"] ?>">
    <p class="error"><?= $model->getFirstError("email") ?></p>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" value="<?= $model->fields["password"] ?>">
    <p class="error"><?= $model->getFirstError("password") ?></p>

    <button type="submit">Register</button>
</form>