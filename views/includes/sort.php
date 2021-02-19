<link rel="stylesheet" href="styles/includes/sort.css">

<?php
use app\src\Request;

function sort_options($default="top", $options = [ "top", "new" ]) {
    function sortedBy(string $method, $default): string {
        $sort = Request::getParameter(Request::METHOD_GET, "sort");
        $isSortedBy = $sort ? $sort === $method : $method === $default;
        return $isSortedBy? "sorted-by" : "";
    }
    ?>
    <form id="sort" method="get">
        <?php foreach ($options as $option): ?>
            <button class="option <?= sortedBy($option, $default) ?>" name="sort" value="<?= $option ?>">
                <?= ucfirst($option) ?>
            </button>
        <?php endforeach; ?>
    </form>
<?php }
?>