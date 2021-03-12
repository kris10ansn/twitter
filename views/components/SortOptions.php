<?php


namespace app\views\components;


use app\src\Request;

/**
 * Class SortOptions
 * @package app\views\components
 */
class SortOptions
{
    private string $default = "top";
    private array $options = ["top", "new"];

    public function default(string $default): SortOptions
    {
        $this->default = $default;
        return $this;
    }

    public function __toString(): string
    {
        $buttons = "";

        $sort = Request::getParameter(Request::METHOD_GET, "sort");

        foreach ($this->options as $option) {
            $sortedBy = (
                $sort ? $sort === $option : $option === $this->default
            ) ? "sorted-by" : "";

            $optionCapitalized = ucfirst($option);

            $buttons .= "
                <button class='option {$sortedBy}' name='sort' value='{$option}'>
                    {$optionCapitalized}
                </button>
            ";
        }

        return "
            <form class='sort' method='get'>
                {$buttons}
            </form>
        ";
    }
}

?>
<link rel="stylesheet" href="styles/components/sort-options.css">

