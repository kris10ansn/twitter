<?php

/** @var UserModel $user */

use app\models\UserModel;
use app\src\Session;

$me = Session::getUser();

?>

<h1><?= "$user->firstname $user->lastname" ?> (<a href="user/<?= $user->id ?>">@<?= $user->username ?></a>)</h1>

<?php if (!$me || $user->id !== $me->id): ?>
    <form action="follow/<?= $user->id ?>" method="post">
        <button type="submit">Follow</button>
    </form>
 <?php endif; ?>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>