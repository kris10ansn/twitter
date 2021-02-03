<?php
/** @var PostModel $post */

use app\models\PostModel;
use app\views\components\PostComponent;

?>

<link rel="stylesheet" href="styles/includes/post.css">

<?= new PostComponent($post) ?>