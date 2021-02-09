
<?php
/** @var UserModel[] $users */

use app\models\UserModel;
use app\src\Session;
use app\src\util\Time;

$me = Session::getUser();
$loggedIn = $me !== null;

?>

<link rel="stylesheet" href="styles/components/user.css">

<h1>Users <?= $loggedIn ? "to follow" : "" ?></h1>

<?php include constant("APP_ROOT") . "/views/includes/sort.php" ?>

<?php foreach ($users as $user): ?>
    <div class="card user">
        <div class="top">
            <div class="user-info">
                <p>
                    <b><?= "$user->firstname $user->lastname" ?></b>
                    (<a href="user/<?= $user->id ?>">@<?= $user->username ?></a>)
                </p>
                <small>
                    <b><?= $user->followerCount() ?></b> followers
                    <span class="gray">Joined <?= Time::since(strtotime($user->created_at)) ?></span>
                </small>
            </div>
            <form action="follow/<?= $user->id ?>" method="post">
                <?php $follows = $loggedIn && $me->follows($user->id); ?>
                <button class="<?= $follows ? "follows" : "" ?>">
                    <?= $follows ? "Unfollow" : "Follow" ?>
                </button>
            </form>
        </div>
        <div class="biography">
            <?= $user->biography ? "<p>$user->biography</p>" : "" ?>
        </div>
    </div>
<?php endforeach; ?>
