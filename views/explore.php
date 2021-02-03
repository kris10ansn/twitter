<?php
/** @var UserModel $user */
/** @var PostFormModel $postFormModel */
/** @var PostModel[] $posts */

use app\models\PostFormModel;
use app\models\PostModel;
use app\models\UserModel;
use app\src\Request;

?>

<link rel="stylesheet" href="styles/views/explore.css">

<h1>Explore</h1>

<?php
function sortedBy(string $method): string {
    $sort = Request::getParameter(Request::METHOD_GET, "sort");
    $isSortedBy = $sort ? $sort === $method : $method === "top";
    return $isSortedBy? "sorted-by" : "";
}
?>

<form id="sort" method="get">
    <button class="option <?= sortedBy('top') ?>" name="sort" value="top">Top</button>
    <button class="option <?= sortedBy('new') ?>" name="sort" value="new">New</button>
</form>

<?php include constant("APP_ROOT") . "/views/includes/posts.php" ?>
