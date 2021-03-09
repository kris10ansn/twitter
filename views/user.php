<?php

/** @var UserModel $user */
/** @var PostFormModel $postFormModel */

use app\models\form\PostFormModel;
use app\models\UserModel;
use app\src\Session;
use app\src\util\Text;

$me = Session::getUser();

$follows = $me && $me->follows($user->id);
?>

<link rel="stylesheet" href="styles/views/user.css">

<div id="user">
    <div class="top">
        <h1><?= "$user->firstname $user->lastname" ?> (<a href="user/<?= $user->id ?>">@<?= $user->username ?></a>)</h1>

        <?php if (!$me || $user->id !== $me->id): ?>
            <form action="user/<?= $user->id ?>/follow" method="post">
                <button type="submit" class="<?= $follows ? 'follows' : '' ?>">
                    <?= !$follows ? "Follow" : "Unfollow"; ?>
                </button>
            </form>
        <?php else: ?>
            <a href="profile/edit">
                <button>Edit profile</button>
            </a>
        <?php endif; ?>
    </div>
    <p><?= Text::render($user->biography) ?? "" ?></p>
    <br><br>
    <p>
        <b><?= $user->followerCount() ?></b>
        <a href="user/<?= $user->id ?>/followers">Followers</a>
        <b><?= $user->followsCount() ?></b>
        <a href="user/<?= $user->id ?>/following">Following</a>
    </p>
</div>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>