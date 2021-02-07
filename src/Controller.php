<?php


namespace app\src;


abstract class Controller
{
    public function renderView(string $viewName, string $layout, array $data=[]): string
    {
        return str_replace(
            "{{content}}",
            $this->renderFile($viewName, $data),
            $layout
        );
    }

    public function renderText(string $text, string $layout)
    {
        return str_replace("{{content}}", $text, $layout);
    }

    public function renderLayout(string $layoutName, array $data=[]): string
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require constant("APP_ROOT") . "/views/layouts/$layoutName.php";
        return ob_get_clean();
    }

    public function renderLayoutInside(string $parentLayout, string $childLayoutName, array $data=[]): string
    {
        return $this->renderView("layouts/$childLayoutName", $parentLayout, $data);
    }

    public function render(string $viewName, string $layoutName, array $data = []): string
    {
        $layoutContent = $this->renderLayout($layoutName, $data);
        return $this->renderView($viewName, $layoutContent, $data);
    }

    private function renderFile(string $file, array $data = []): string {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $root = constant("APP_ROOT");
        ob_start();
        require($root . "/views/$file.php");
        return ob_get_clean();
    }
}