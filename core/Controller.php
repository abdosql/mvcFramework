<?php

namespace app\core;

class Controller
{
    public $test = 1;
    private string $layout = "main";
    public function setLayout($l){
        $this->layout = $l;
    }
    public function getLayout(){
        return $this->layout;
    }
    public function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }
    public function getBody(){
        return Application::$app->request->getBody();
    }

    
}
