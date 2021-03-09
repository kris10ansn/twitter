
<?php
/** @var UserModel[] $users */
/** @var string $text */

use app\models\UserModel;
use app\src\util\Text;
use app\views\components\UserCardComponent;
?>

<h1><?= Text::render($text) ?></h1>

<?php include_once constant("APP_ROOT") . "/views/includes/sort.php" ?>

<?php sort_options() ?>

<?php foreach ($users as $user): ?>
    <?= new UserCardComponent($user) ?>
<?php endforeach; ?>
