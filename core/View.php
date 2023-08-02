<?php

namespace app\core;

class View
{
    private string $title = "";
    protected function layoutContent() {
        $layout = Application::$app->layout;
        if (Application::$app->controller){
            $layout = Application::$app->layout;
        }
        ob_start();
        require_once Application::$ROOT_DIR."/Views/_layouts/$layout.php";
        return ob_get_clean();
    }
    public function renderView($view, $params = []) {
        $viewContent = $this->renderOnlyView($view, $params);
        $_layout = $this->layoutContent();
        return str_replace("{{view}}",$viewContent,$_layout);
    }
    protected function renderOnlyView($view, $params = []){
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        require_once Application::$ROOT_DIR."/Views/$view.php";
        return ob_get_clean();
    }

    /**
     * @return void
     */
    public function getTitle(): void
    {
        echo $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}