
<?php
/** @var UserModel[] $users */
/** @var string $text */

use app\models\UserModel;
use app\src\util\Text;
use app\views\components\SortOptions;
use app\views\components\UserCardComponent;
?>

<h1><?= Text::render($text) ?></h1>

<?= new SortOptions() ?>

<?php foreach ($users as $user): ?>
    <?= new UserCardComponent($user) ?>
<?php endforeach; ?>
