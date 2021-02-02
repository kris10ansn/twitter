<?php

/** @var UserModel $user */

use app\models\UserModel;

?>

<h1>User <a href="user/<?= $user->id ?>">@<?= $user->username ?></a></h1>