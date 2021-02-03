<link rel="stylesheet" href="styles/includes/sort.css">

<?php
use app\src\Request;

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