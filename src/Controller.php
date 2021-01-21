<?php


namespace app\src;


abstract class Controller
{
    private string $layout = "main";

    public function render($view, $data = []): string
    {
        $layoutContent = $this->renderFile("layouts/$this->layout");
        $viewContent = $this->renderFile($view, $data);
        return str_replace("{{content}}", $viewContent, $layoutContent);
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

    protected function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
}