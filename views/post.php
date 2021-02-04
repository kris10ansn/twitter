<?php
/** @var PostModel $post */

use app\models\PostModel;
use app\views\components\PostComponent;

?>

<link rel="stylesheet" href="styles/components/post.css">

<?= new PostComponent($post, false) ?>