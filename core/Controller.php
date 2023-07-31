<?php

namespace app\core;

class Controller
{
    public string $layout = "main";
    public function setLayout($l){
        $this->layout = $l;
    }
    public function getLayout(): string
    {
        return $this->layout;
    }
    public function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }
    public function getBody(){
        Application::$app->request->getBody();
    }

    
}
