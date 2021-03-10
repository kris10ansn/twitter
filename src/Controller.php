<?php


namespace app\src;


/**
 * Class Controller
 * @package app\src
 */
abstract class Controller
{
    private function renderView(string $viewName, string $layout, array $data=[]): string
    {
        return str_replace(
            "{{content}}",
            $this->renderFile($viewName, $data),
            $layout
        );
    }

    private function renderLayout(string $layoutName, array $data=[]): string
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

    /**
     * @param array $data
     * @param string $viewName
     * @param string ...$layouts
     * @return string
     */
    public function render(array $data, string $viewName, ...$layouts): string
    {
        $layout = "";

        for ($i = 0; $i < count($layouts); $i++) {
            if ($i === 0) {
                $layout = $this->renderLayout($layouts[$i], $data);
                continue;
            }

            $layout = $this->renderLayoutInside($layout, $layouts[$i], $data);
        }

        return $this->renderView($viewName, $layout, $data);
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