
<?php
/** @var UserModel[] $users */

use app\models\UserModel;
use app\src\Session;
use app\views\components\UserCardComponent;

$me = Session::getUser();
$loggedIn = $me !== null;

?>

<h1>Users <?= $loggedIn ? "to follow" : "" ?></h1>

<?php include_once constant("APP_ROOT") . "/views/includes/sort.php" ?>

<?php sort_options() ?>

<?php foreach ($users as $user): ?>
    <?= new UserCardComponent($user) ?>
<?php endforeach; ?>
