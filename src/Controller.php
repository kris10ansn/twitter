<?php


namespace app\src;


abstract class Controller
{
    public function renderView($viewName, $layout, $data=[])
    {
        return str_replace(
            "{{content}}",
            $this->renderFile($viewName, $data),
            $layout
        );
    }

    public function renderLayout($layoutName, $data=[])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require constant("APP_ROOT") . "/views/layouts/$layoutName.php";
        return ob_get_clean();
    }

    public function renderLayoutInside($parentLayout, $childLayoutName, $data=[])
    {
        return $this->renderView("layouts/$childLayoutName", $parentLayout, $data);
    }

    public function render($viewName, $layoutName, $data = []): string
    {
        $layoutContent = $this->renderLayout($layoutName, $data);
        return $this->renderView($viewName, $layoutContent, $data);
    }

    private function renderFile($file, $data = []) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $root = constant("APP_ROOT");
        ob_start();
        require($root . "/views/$file.php");
        return ob_get_clean();
    }
}