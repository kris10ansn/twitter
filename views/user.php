<?php

/** @var UserModel $user */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\form\PostFormModel;
use app\models\PostModel;
use app\models\UserModel;
use app\src\Session;
use app\src\util\Text;
use app\views\components\PostsComponent;

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
    <?php if ($user->favorite_user !== null):
        $favorite_user = UserModel::from($user->favorite_user);
        ?>
        <br><br>

        <p>
            <b>⭐ Favorite user: </b>
            <?= $favorite_user->firstname ?> <?= $favorite_user->lastname ?>
            (<a href="user/<?= $favorite_user->id ?>">@<?= $favorite_user->username ?></a>)
        </p>
     <?php endif; ?>
    <br><br>
    <p>
        <b><?= $user->followerCount() ?></b>
        <a href="user/<?= $user->id ?>/followers">Followers</a>
        <b><?= $user->followsCount() ?></b>
        <a href="user/<?= $user->id ?>/following">Following</a>
    </p>
</div>

<?= new PostsComponent($posts) ?>