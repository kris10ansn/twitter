<?php

/** @var UserModel $user */

use app\models\UserModel;
use app\src\Session;

$me = Session::getUser();

$follows = $me->follows($user->id);
?>

<link rel="stylesheet" href="styles/views/user.css">

<div id="user">
    <h1><?= "$user->firstname $user->lastname" ?> (<a href="user/<?= $user->id ?>">@<?= $user->username ?></a>)</h1>

    <?php if ($me && $user->id !== $me->id): ?>
        <form action="follow/<?= $user->id ?>" method="post">
            <button type="submit" class="<?= $follows ? 'follows' : '' ?>">
                <?= !$follows ? "Follow" : "Unfollow"; ?>
            </button>
        </form>
    <?php endif; ?>
</div>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>